<?php

namespace App\Repositories\Seguridad;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolRepository
{
    public function listar(): Collection
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $columna = $this->columnaDelRol();

        $conteos = DB::table(config('permission.table_names.model_has_roles'))
            ->select($columna, DB::raw('count(*) as total'))
            ->groupBy($columna)
            ->pluck('total', $columna);

        foreach ($roles as $rol) {
            $rol->users_count = $conteos[$rol->getKey()] ?? 0;
        }

        return $roles;
    }

    public function listarNombres(): array
    {
        return Role::orderBy('name')->pluck('name')->all();
    }

    public function crear(string $nombre, bool $activo, array $permisos): Role
    {
        $rol = Role::create([
            'name' => $nombre,
            'guard_name' => config('seguridad.guard'),
            'activo' => $activo,
        ]);

        $rol->syncPermissions($permisos);

        return $rol;
    }

    public function actualizar(Role $rol, string $nombre, bool $activo, array $permisos): void
    {
        $rol->update(['name' => $nombre, 'activo' => $activo]);
        $rol->syncPermissions($permisos);
    }

    public function cambiarEstado(Role $rol, bool $activo): void
    {
        $rol->update(['activo' => $activo]);
    }

    public function eliminar(Role $rol): void
    {
        $rol->delete();
    }

    public function contarUsuarios(Role $rol): int
    {
        return DB::table(config('permission.table_names.model_has_roles'))
            ->where($this->columnaDelRol(), $rol->getKey())
            ->count();
    }

    public function buscarPorNombre(string $nombre): ?Role
    {
        return Role::where('name', $nombre)->where('guard_name', config('seguridad.guard'))->first();
    }

    private function columnaDelRol(): string
    {
        return config('permission.column_names.role_pivot_key') ?? 'role_id';
    }
}
