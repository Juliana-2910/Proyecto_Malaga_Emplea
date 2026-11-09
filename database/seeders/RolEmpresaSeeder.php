<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolEmpresaSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $rol = Role::findOrCreate(config('seguridad.rol_empresa'), config('seguridad.guard'));
        $rol->update(['activo' => true]);

        Empresa::query()->each(fn (Empresa $empresa) => $empresa->assignRole($rol));

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
