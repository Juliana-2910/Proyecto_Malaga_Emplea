<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Services\Seguridad\AuthService;
use App\Services\usuariosService;
use App\Services\empresasServices;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function registrarUsuario(Request $request, usuariosService $usuariosService)
    {
        $datos = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'fechaNacimiento' => 'required|date',
            'tipoDocumento' => [
                'required',
                Rule::in(['CC', 'CE', 'PPT', 'PEP', 'PASAPORTE']),
        ],
        'numeroDocumento' => 'required|string|max:30|unique:usuarios,numeroDocumento',
        'telefono' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:usuarios,email',
        'password' => 'required|string|min:8',
    ]);

    $usuariosService->guardar($datos);

    $autenticado = $this->authService->autenticar(
        $datos['email'],
        $datos['password'],
        false,
        'usuario'
    );

    if (! $autenticado) {
        return response()->json([
            'mensaje' => 'La cuenta fue creada, pero debes iniciar sesión.',
            'redirect' => route('login'),
        ], 201);
    }

    $request->session()->regenerate();

    return response()->json([
        'mensaje' => 'Tu cuenta fue registrada correctamente.',
        'redirect' => route('Publico.ofertas'),
    ], 201);
}

public function registrarEmpresa(Request $request, empresasServices $empresasServices)
{
    $datos = $request->validate([
        'nombreEmpresa' => 'required|string|max:150',
        'nit' => 'required|string|max:30|unique:empresas,nit',
        'direccion' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:empresas,email',
        'password' => 'required|string|min:8',
    ]);

    $datos['estado'] = 'activo';

    $empresasServices->guardar($datos);

    $autenticado = $this->authService->autenticar(
        $datos['email'],
        $datos['password'],
        false,
        'empresa'
    );

    if (! $autenticado) {
        return response()->json([
            'mensaje' => 'La empresa fue creada, pero debes iniciar sesión.',
            'redirect' => route('login'),
        ], 201);
    }

    $request->session()->regenerate();

    return response()->json([
        'mensaje' => 'La empresa fue registrada correctamente.',
        'redirect' => route('Publico.misOfertas'),
    ], 201);
}

    public function __construct(private AuthService $authService) {}

    public function showLoginForm(): View
    {
        return view('seguridad.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $tipos = array_keys(config('seguridad.login') ?? ['usuario' => true]);

        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'tipo' => ['nullable', Rule::in($tipos)],
        ]);

        try {
            $autenticado = $this->authService->autenticar(
                $credenciales['email'],
                $credenciales['password'],
                $request->boolean('remember'),
                $credenciales['tipo'] ?? 'usuario'
            );
        } catch (Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->onlyInput('email', 'tipo');
        }

        if (! $autenticado) {
            $intentosRestantes = max(0, 5 - RateLimiter::attempts($this->loginRateLimitKey($request)));
            $mensaje = $intentosRestantes > 0
                ? "Las credenciales no coinciden. Te quedan {$intentosRestantes} intentos antes de un bloqueo temporal."
                : 'Las credenciales no coinciden. Se agotaron tus intentos y el acceso quedó bloqueado temporalmente.';

            return back()
                ->withErrors(['email' => $mensaje])
                ->with('loginIntentosRestantes', $intentosRestantes)
                ->onlyInput('email', 'tipo');
        }

        RateLimiter::clear($this->loginRateLimitKey($request));
        $request->session()->regenerate();
        $tipo = $credenciales['tipo'] ?? 'usuario';

        if ($tipo === 'empresa') {
            return redirect()->route('Publico.misOfertas');
        }

        $cuenta = auth('web')->user();

        if (! $cuenta?->hasRole(config('seguridad.rol_admin'))) {
            return redirect()->route('Publico.ofertas');
        }

        return redirect()->intended(config('seguridad.redirect_despues_login'));
    }

    private function loginRateLimitKey(Request $request): string
    {
        return md5('login' . $request->ip());
    }

    // Cerrar sesión
    public function logout(Request $request): RedirectResponse
    {
        $this->authService->cerrarSesion();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
