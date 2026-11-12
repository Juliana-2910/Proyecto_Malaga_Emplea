<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermisosEmpresaSeeder extends Seeder
{
    public function run(): void
    {
        $guard = config('seguridad.guard');
        $permisos = [
            'perfil' => ['ver', 'editar'],
            'ofertas' => ['ver', 'crear', 'editar'],
            'postulacion' => ['ver', 'editar'],
            'calificacion' => ['ver', 'crear'],
        ];

        foreach ($permisos as $modulo => $acciones) {
            foreach ($acciones as $accion) {
                $permiso = Permission::firstOrCreate(
                    ['name' => $accion . ' ' . $modulo, 'guard_name' => $guard],
                    ['modulo' => $modulo]
                );

                if ($permiso->modulo === null) {
                    $permiso->update(['modulo' => $modulo]);
                }
            }
        }

        $administrador = Role::where('name', config('seguridad.rol_admin'))
            ->where('guard_name', $guard)
            ->first();
        $administrador?->givePermissionTo(Permission::where('guard_name', $guard)
            ->whereIn('name', collect($permisos)
                ->flatMap(fn (array $acciones, string $modulo) => collect($acciones)->map(fn (string $accion) => $accion . ' ' . $modulo))
                ->all())
            ->get());

        $rolEmpresa = Role::where('name', config('seguridad.rol_empresa'))
            ->where('guard_name', $guard)
            ->first();

        // La primera configuración permite usar el portal; los cambios posteriores
        // quedan bajo control del administrador desde Seguridad > Roles.
        if ($rolEmpresa && $rolEmpresa->permissions()->count() === 0) {
            $rolEmpresa->givePermissionTo([
                'ver perfil', 'editar perfil',
                'ver ofertas', 'crear ofertas', 'editar ofertas',
                'ver postulacion', 'editar postulacion',
                'ver calificacion', 'crear calificacion',
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
