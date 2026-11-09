<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Services\Seguridad\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
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
            return back()
                ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])
                ->onlyInput('email', 'tipo');
        }

        $request->session()->regenerate();

        $cuenta = auth('web')->user();

        if (
            ($credenciales['tipo'] ?? 'usuario') === 'usuario'
            && ! $cuenta?->hasRole(config('seguridad.rol_admin'))
        ) {
            return redirect()->route('Publico.ofertas');
        }

                return redirect()->intended(config('seguridad.redirect_despues_login'));
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
