<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seguridad\LoginRequest;
use App\Http\Requests\Seguridad\RegistrarEmpresaRequest;
use App\Http\Requests\Seguridad\RegistrarUsuarioRequest;
use App\Services\Seguridad\AuthService;
use App\Services\Seguridad\RegistroService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private RegistroService $registroService
    ) {}

    public function showLoginForm(): View
    {
        return view('seguridad.login');
    }

    public function registrarUsuario(RegistrarUsuarioRequest $request)
    {
        $datos = $request->validated();

        $autenticado = $this->registroService->registrarUsuario($datos);

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

    public function registrarEmpresa(RegistrarEmpresaRequest $request)
    {
        $datos = $request->validated();

        $autenticado = $this->registroService->registrarEmpresa($datos);

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

    public function login(LoginRequest $request): RedirectResponse
    {
        $credenciales = $request->validated();

        try {
            $autenticado = $this->authService->autenticar(
                $credenciales['email'],
                $credenciales['password'],
                $request->boolean('remember'),
                $credenciales['tipo'] ?? 'usuario'
            );
        } catch (Exception $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->onlyInput('email', 'tipo');
        }

        if (! $autenticado) {
            $intentosRestantes = max(
                0,
                5 - RateLimiter::attempts($this->loginRateLimitKey($request))
            );

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

        if ($cuenta?->hasRole(config('seguridad.rol_admin'))) {
            return redirect()->route('dashboard.index');
        }

        return redirect()->intended(
            config('seguridad.redirect_despues_login')
        );
    }

    private function loginRateLimitKey(Request $request): string
    {
        return md5('login' . $request->ip());
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->cerrarSesion();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
