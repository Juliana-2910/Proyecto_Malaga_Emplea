<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SeguridadSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = config('seguridad.guard');

        $permisoAdmin = Permission::firstOrCreate(
            ['name' => config('seguridad.permiso_admin'), 'guard_name' => $guard],
            ['modulo' => 'seguridad']
        );

        if ($permisoAdmin->modulo === null) {
            $permisoAdmin->update(['modulo' => 'seguridad']);
        }

        $rolAdmin = Role::firstOrCreate(
            ['name' => config('seguridad.rol_admin'), 'guard_name' => $guard],
            ['activo' => true]
        );
        $rolAdmin->update(['activo' => true]);
        $rolAdmin->syncPermissions(Permission::where('guard_name', $guard)->get());

        $modelo = config('auth.providers.users.model');
        $datos = config('seguridad.admin');

        $admin = $modelo::firstOrCreate(
            ['email' => $datos['email']],
            [
                'nombres' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'tipoDocumento' => 'CC',
                'numeroDocumento' => '00000000',
                'telefono' => '3000000000',
                'password' => Hash::make($datos['password']),
                'estado' => 'activo'
            ]
        );
        $admin->assignRole($rolAdmin);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
