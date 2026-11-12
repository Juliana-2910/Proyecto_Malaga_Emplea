<?php

namespace App\Http\Middleware\Seguridad;

use Closure;
use App\Models\Empresa;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Aplica permisos administrativos del rol Empresa a sus acciones del portal público. */
class AutorizarPermisoEmpresa
{
    public function handle(Request $request, Closure $next, string $permiso): Response
    {
        $cuenta = $request->user();
        $empresa = $cuenta instanceof Empresa ? $cuenta : null;

        // Las rutas públicas también sirven al rol Usuario, que mantiene su flujo actual.
        if ($empresa && ! $empresa->can($permiso)) {
            throw new AuthorizationException('Tu cuenta de empresa no tiene permiso para realizar esta acción.');
        }

        return $next($request);
    }
}
