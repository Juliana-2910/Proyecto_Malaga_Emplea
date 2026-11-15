<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\Usuario;
use Database\Seeders\PermisosEmpresaSeeder;
use Database\Seeders\SeguridadSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CambiarContrasenaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SeguridadSeeder::class);
        $this->artisan('seguridad:modulo', ['nombres' => ['perfil', 'ofertas', 'postulacion', 'calificacion']]);
        $this->seed(PermisosEmpresaSeeder::class);
    }

    private function usuario(): Usuario
    {
        return Usuario::create([
            'nombres' => 'Laura', 'apellidos' => 'Pérez', 'email' => 'persona@example.com',
            'password' => 'password', 'fechaNacimiento' => '1995-01-01', 'tipoDocumento' => 'CC',
            'numeroDocumento' => '123456', 'telefono' => '3000000000', 'fechaRegistro' => now(), 'estado' => 'activo',
        ]);
    }

    private function empresa(): Empresa
    {
        return Empresa::create([
            'nombreEmpresa' => 'Acme Málaga', 'nit' => '900123456', 'direccion' => 'Centro, Málaga',
            'email' => 'empresa@example.com', 'password' => 'password', 'estado' => 'activo',
        ]);
    }

    public function test_persona_cambia_su_contrasena(): void
    {
        $usuario = $this->usuario();

        $this->actingAs($usuario, 'web')->put(route('perfil.contrasena'), [
            'contrasena_actual' => 'password',
            'password' => 'nueva-clave-123',
            'password_confirmation' => 'nueva-clave-123',
        ])->assertSessionHas('contrasenaActualizada');

        $this->assertTrue(Hash::check('nueva-clave-123', $usuario->fresh()->password));
    }

    public function test_empresa_cambia_su_contrasena(): void
    {
        $empresa = $this->empresa();

        $this->actingAs($empresa, 'empresa')->put(route('perfil.contrasena'), [
            'contrasena_actual' => 'password',
            'password' => 'nueva-clave-123',
            'password_confirmation' => 'nueva-clave-123',
        ])->assertSessionHas('contrasenaActualizada');

        $this->assertTrue(Hash::check('nueva-clave-123', $empresa->fresh()->password));
    }

    public function test_rechaza_si_la_contrasena_actual_es_incorrecta(): void
    {
        $usuario = $this->usuario();

        $this->actingAs($usuario, 'web')->put(route('perfil.contrasena'), [
            'contrasena_actual' => 'equivocada',
            'password' => 'nueva-clave-123',
            'password_confirmation' => 'nueva-clave-123',
        ])->assertSessionHasErrors('servicio', null, 'contrasena');

        $this->assertTrue(Hash::check('password', $usuario->fresh()->password));
    }

    public function test_rechaza_si_la_confirmacion_no_coincide(): void
    {
        $this->actingAs($this->usuario(), 'web')->put(route('perfil.contrasena'), [
            'contrasena_actual' => 'password',
            'password' => 'nueva-clave-123',
            'password_confirmation' => 'otra-cosa',
        ])->assertSessionHasErrors('password', null, 'contrasena');
    }

    public function test_el_documento_no_se_puede_modificar_desde_el_perfil(): void
    {
        $usuario = $this->usuario();

        $this->actingAs($usuario, 'web')->put(route('perfil.actualizar'), [
            'nombres' => 'Laura', 'apellidos' => 'Pérez', 'fechaNacimiento' => '1995-01-01',
            'telefono' => '3000000000', 'email' => $usuario->email,
            'tipoDocumento' => 'CE', 'numeroDocumento' => '999999',
        ])->assertSessionHas('success');

        $this->assertSame('CC', $usuario->fresh()->tipoDocumento);
        $this->assertSame('123456', $usuario->fresh()->numeroDocumento);
    }
}
