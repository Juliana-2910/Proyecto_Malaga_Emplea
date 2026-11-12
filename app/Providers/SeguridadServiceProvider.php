<?php

namespace App\Providers;

use App\Http\Middleware\Seguridad\AutorizarModulo;
use App\Http\Middleware\Seguridad\AutorizarPermisoEmpresa;
use App\Http\Middleware\Seguridad\VerificarCuentaActiva;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class SeguridadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::before(function ($usuario, string $habilidad): ?bool {
            if (! method_exists($usuario, 'hasRole')) {
                return null;
            }

            return $usuario->hasRole(config('seguridad.rol_admin')) ? true : null;
        });

        $this->app['router']->aliasMiddleware('modulo', AutorizarModulo::class);
        $this->app['router']->aliasMiddleware('empresa.permiso', AutorizarPermisoEmpresa::class);
        $this->app['router']->aliasMiddleware('cuenta.activa', VerificarCuentaActiva::class);

        $this->loadRoutesFrom(base_path('routes/seguridad.php'));
    }
}
