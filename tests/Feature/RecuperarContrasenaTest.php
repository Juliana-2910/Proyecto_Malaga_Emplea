<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\Usuario;
use App\Notifications\RestablecerContrasena;
use Database\Seeders\SeguridadSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class RecuperarContrasenaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SeguridadSeeder::class);
    }

    private function usuario(): Usuario
    {
        return Usuario::create([
            'nombres' => 'Laura',
            'apellidos' => 'Pérez',
            'email' => 'persona@example.com',
            'password' => 'password-anterior',
            'fechaNacimiento' => '1995-01-01',
            'tipoDocumento' => 'CC',
            'numeroDocumento' => 'CC-123456',
            'telefono' => '3000000000',
            'fechaRegistro' => now(),
            'estado' => 'activo',
        ]);
    }

    private function empresa(): Empresa
    {
        return Empresa::create([
            'nombreEmpresa' => 'Acme Málaga',
            'nit' => '900123456',
            'direccion' => 'Centro, Málaga',
            'email' => 'empresa@example.com',
            'password' => 'password-anterior',
            'estado' => 'activo',
        ]);
    }

    public function test_login_presenta_la_recuperacion_y_solicita_el_correo_de_forma_privada(): void
    {
        Notification::fake();
        $usuario = $this->usuario();
        $empresa = $this->empresa();

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('¿Olvidaste tu contraseña?')
            ->assertSee('modalRecuperarContrasena')
            ->assertSee('data-tipo-recuperacion="usuario"', false)
            ->assertSee('data-tipo-recuperacion="empresa"', false)
            ->assertSee('Inicia sesión')
            ->assertDontSee('<h1 class="text-3xl font-extrabold tracking-tight text-[#333333]">Málaga Emplea</h1>', false);

        $this->post(route('password.email'), [
            'tipo_recuperacion' => 'usuario',
            'email_recuperacion' => $usuario->email,
        ])->assertRedirect()->assertSessionHas('statusRecuperacion');
        Notification::assertSentTo($usuario, RestablecerContrasena::class, fn (RestablecerContrasena $n) => $n->tipoCuenta === 'usuario');

        $this->post(route('password.email'), [
            'tipo_recuperacion' => 'empresa',
            'email_recuperacion' => $empresa->email,
        ])->assertRedirect()->assertSessionHas('statusRecuperacion');
        Notification::assertSentTo($empresa, RestablecerContrasena::class, fn (RestablecerContrasena $n) => $n->tipoCuenta === 'empresa');

        $this->post(route('password.email'), [
            'tipo_recuperacion' => 'empresa',
            'email_recuperacion' => 'inexistente@example.com',
        ])->assertRedirect()->assertSessionHas('statusRecuperacion');
        Notification::assertCount(2);
    }

    public function test_persona_y_empresa_pueden_cambiar_contrasena_con_token_de_un_solo_uso(): void
    {
        $usuario = $this->usuario();
        $tokenUsuario = Password::broker('users')->createToken($usuario);

        $this->get(route('password.reset', ['tipo' => 'usuario', 'token' => $tokenUsuario, 'email' => $usuario->email]))
            ->assertOk()->assertSee('Crea tu contraseña')->assertSee('Cuenta personal');
        $this->post(route('password.update'), [
            'tipo' => 'usuario', 'token' => $tokenUsuario, 'email' => $usuario->email,
            'password' => 'nueva-clave-123', 'password_confirmation' => 'nueva-clave-123',
        ])->assertRedirect(route('login'))->assertSessionHas('successRecuperacion');
        $this->assertTrue(Hash::check('nueva-clave-123', $usuario->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $usuario->email]);

        $empresa = $this->empresa();
        $tokenEmpresa = Password::broker('empresas')->createToken($empresa);
        $this->get(route('password.reset', ['tipo' => 'empresa', 'token' => $tokenEmpresa, 'email' => $empresa->email]))
            ->assertOk()->assertSee('Cuenta empresa');
        $this->post(route('password.update'), [
            'tipo' => 'empresa', 'token' => $tokenEmpresa, 'email' => $empresa->email,
            'password' => 'otra-clave-123', 'password_confirmation' => 'otra-clave-123',
        ])->assertRedirect(route('login'))->assertSessionHas('successRecuperacion');
        $this->assertTrue(Hash::check('otra-clave-123', $empresa->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens_empresas', ['email' => $empresa->email]);
    }

    public function test_tarjeta_azul_de_empresa_depende_del_permiso_de_creacion(): void
    {
        $this->artisan('seguridad:modulo', ['nombres' => ['perfil', 'ofertas', 'postulacion', 'calificacion']]);
        $this->seed(\Database\Seeders\PermisosEmpresaSeeder::class);
        $empresa = $this->empresa();

        $this->actingAs($empresa, 'empresa')->get(route('Publico.misOfertas'))
            ->assertOk()->assertSee('¿Necesitas contratar a alguien?')->assertSee('Publicar una oferta');

        $empresa->roles()->first()->revokePermissionTo('crear ofertas');
        $this->actingAs($empresa, 'empresa')->get(route('Publico.misOfertas'))
            ->assertOk()->assertDontSee('Publicar una oferta');
    }

    public function test_login_informa_intentos_restantes_y_muestra_el_bloqueo_temporal(): void
    {
        RateLimiter::clear(md5('login127.0.0.1'));
        $this->usuario();

        for ($intento = 1; $intento <= 5; $intento++) {
            $this->from(route('login'))->post(route('login.store'), [
                'tipo' => 'usuario',
                'email' => 'persona@example.com',
                'password' => 'clave-incorrecta',
            ])->assertRedirect(route('login'))
                ->assertSessionHas('loginIntentosRestantes', 5 - $intento);
        }

        $this->from(route('login'))->post(route('login.store'), [
            'tipo' => 'usuario',
            'email' => 'persona@example.com',
            'password' => 'clave-incorrecta',
        ])->assertRedirect(route('login'))
            ->assertSessionHas('loginBloqueoSegundos');
    }
}
