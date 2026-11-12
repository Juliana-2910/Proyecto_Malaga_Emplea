<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RecuperarContrasenaController extends Controller
{
    public function enviarEnlace(Request $request): RedirectResponse
    {
        $datos = $request->validateWithBag('recovery', [
            'tipo_recuperacion' => ['required', Rule::in(['usuario', 'empresa'])],
            'email_recuperacion' => ['required', 'email', 'max:255'],
        ], [
            'tipo_recuperacion.required' => 'Selecciona el tipo de cuenta.',
            'email_recuperacion.required' => 'Ingresa el correo asociado a tu cuenta.',
            'email_recuperacion.email' => 'Ingresa un correo electrónico válido.',
        ]);

        $tipo = $datos['tipo_recuperacion'];
        $broker = $this->broker($tipo);
        $modelo = config("seguridad.login.$tipo.modelo");
        $cuentaActiva = $modelo::query()
            ->where('email', $datos['email_recuperacion'])
            ->whereRaw('LOWER(estado) = ?', ['activo'])
            ->exists();

        if ($cuentaActiva) {
            Password::broker($broker)->sendResetLink([
                'email' => $datos['email_recuperacion'],
            ]);
        }

        return back()
            ->with('statusRecuperacion', 'Si el correo pertenece a una cuenta activa, recibirás un enlace para crear una nueva contraseña.')
            ->withInput([
                'email' => $request->input('email'),
                'tipo' => $request->input('tipo'),
            ]);
    }

    public function formulario(Request $request, string $tipo, string $token): View
    {
        abort_unless(in_array($tipo, ['usuario', 'empresa'], true), 404);

        return view('seguridad.restablecer-contrasena', [
            'tipo' => $tipo,
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function actualizar(Request $request): RedirectResponse
    {
        $datos = $request->validateWithBag('resetPassword', [
            'tipo' => ['required', Rule::in(['usuario', 'empresa'])],
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Ingresa tu nueva contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $status = Password::broker($this->broker($datos['tipo']))->reset(
            [
                'email' => $datos['email'],
                'password' => $datos['password'],
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $datos['token'],
            ],
            function ($cuenta, string $password): void {
                $cambios = ['password' => Hash::make($password)];
                $columnaToken = $cuenta->getRememberTokenName();

                if ($columnaToken !== '') {
                    $cambios[$columnaToken] = Str::random(60);
                }

                $cuenta->forceFill($cambios)->save();

                event(new PasswordReset($cuenta));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with(
                'successRecuperacion',
                'Tu contraseña fue actualizada. Ya puedes iniciar sesión.'
            );
        }

        $mensaje = $status === Password::INVALID_TOKEN
            ? 'El enlace venció o ya fue utilizado. Solicita uno nuevo desde el inicio de sesión.'
            : 'No encontramos una cuenta para restablecer con ese enlace.';

        return back()
            ->withErrors(['email' => $mensaje], 'resetPassword')
            ->withInput($request->only('tipo', 'email', 'token'));
    }

    private function broker(string $tipo): string
    {
        return $tipo === 'empresa' ? 'empresas' : 'users';
    }
}
