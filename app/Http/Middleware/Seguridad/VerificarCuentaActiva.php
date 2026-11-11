<?php

namespace App\Http\Middleware\Seguridad;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarCuentaActiva
{
    public function handle(Request $request, Closure $next): Response
    {
        $cuenta = $request->user();

        if ($cuenta === null || strtolower((string) $cuenta->estado) === 'activo') {
            return $next($request);
        }

        foreach (config('seguridad.login', []) as $configuracion) {
            if (($configuracion['modelo'] ?? null) === $cuenta::class) {
                Auth::guard($configuracion['guard'])->logout();
                break;
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('error', 'Tu cuenta está inactiva. Comunícate con el administrador.');
    }
}
