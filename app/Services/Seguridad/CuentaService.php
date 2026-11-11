<?php

namespace App\Services\Seguridad;

use App\Repositories\Seguridad\RolRepository;
use App\Repositories\Seguridad\UsuarioRepository;
use App\Models\Empresa;
use App\Models\Usuario;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class CuentaService
{
    public function __construct(
        private UsuarioRepository $usuarioRepository,
        private RolRepository $rolRepository,
    ) {
    }

    public function listar(): Collection
    {
        return $this->usuarioRepository->listarConRoles();
    }

    public function listarRoles(): Collection
    {
        return $this->rolRepository->listar();
    }

    public function listarEmpresas(): Collection
    {
        return Empresa::with('rolesConInactivos')->orderBy('nombreEmpresa')->get();
    }

    public function cambiarEstado(Authenticatable $cuenta, Authenticatable $actual): bool
    {
        $activar = strtolower((string) $cuenta->estado) !== 'activo';

        if (! $activar && $cuenta->is($actual)) {
            throw new Exception('No puedes inactivar tu propia cuenta.');
        }

        $rolAdmin = config('seguridad.rol_admin');
        if (! $activar && $cuenta instanceof Usuario && $cuenta->hasRole($rolAdmin)) {
            $administradoresActivos = Usuario::query()
                ->whereRaw('LOWER(estado) = ?', ['activo'])
                ->whereHas('roles', fn ($consulta) => $consulta->where('name', $rolAdmin))
                ->count();

            if ($administradoresActivos <= 1) {
                throw new Exception('No puedes inactivar al único administrador activo.');
            }
        }

        $cuenta->update(['estado' => $activar ? 'activo' : 'inactivo']);

        return $activar;
    }

    public function buscar(int|string $id): Authenticatable
    {
        return $this->usuarioRepository->buscarPorId($id)->load('rolesConInactivos');
    }

    public function crear(array $datos, array $roles): void
    {
        $datos['password'] = Hash::make($datos['password']);

        DB::transaction(function () use ($datos, $roles): void {
            $usuario = $this->usuarioRepository->crear($datos);
            $this->usuarioRepository->sincronizarRoles($usuario, $roles);
        });

        $this->limpiarCache();
    }

    public function actualizar(Authenticatable $usuario, array $datos, array $roles, Authenticatable $actual): void
    {
        $rolAdmin = config('seguridad.rol_admin');

        $seQuitaSuRolAdmin = $usuario->is($actual)
            && $usuario->rolesConInactivos->contains('name', $rolAdmin)
            && ! in_array($rolAdmin, $roles, true);

        if ($seQuitaSuRolAdmin) {
            throw new Exception('No puedes quitarte tu propio rol de ' . $rolAdmin . '.');
        }

        if (empty($datos['password'])) {
            unset($datos['password']);
        } else {
            $datos['password'] = Hash::make($datos['password']);
        }

        DB::transaction(function () use ($usuario, $datos, $roles): void {
            $this->usuarioRepository->actualizar($usuario, $datos);
            $this->usuarioRepository->sincronizarRoles($usuario, $roles);
        });

        $this->limpiarCache();
    }

    public function eliminar(Authenticatable $usuario, Authenticatable $actual): void
    {
        if ($usuario->is($actual)) {
            throw new Exception('No puedes eliminar tu propia cuenta.');
        }

        $rolAdmin = config('seguridad.rol_admin');
        $esAdmin = $usuario->rolesConInactivos->contains('name', $rolAdmin);

        if ($esAdmin && $this->usuarioRepository->contarConRol($rolAdmin) <= 1) {
            throw new Exception('No puedes eliminar al único usuario con el rol ' . $rolAdmin . '.');
        }

        $this->usuarioRepository->eliminar($usuario);
        $this->limpiarCache();
    }

    private function limpiarCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
