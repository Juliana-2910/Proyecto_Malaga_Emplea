<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\Postulacion;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelPublicoTest extends TestCase
{
    use RefreshDatabase;

    private function usuario(string $email = 'persona@example.com'): Usuario
    {
        return Usuario::create([
            'nombres' => 'Laura',
            'apellidos' => 'Pérez',
            'email' => $email,
            'password' => 'password',
            'fechaNacimiento' => '1995-01-01',
            'tipoDocumento' => 'CC',
            'numeroDocumento' => $email,
            'telefono' => '3000000000',
            'fechaRegistro' => now(),
            'estado' => 'activo',
        ]);
    }

    private function empresa(): Empresa
    {
        return Empresa::withoutEvents(fn () => Empresa::create([
            'nombreEmpresa' => 'Acme Málaga',
            'nit' => '900123456',
            'direccion' => 'Centro, Málaga',
            'email' => 'empresa@example.com',
            'password' => 'password',
            'estado' => 'activo',
        ]));
    }

    private function oferta(Empresa $empresa): Oferta
    {
        return Oferta::create([
            'titulo' => 'Auxiliar de cocina',
            'descripcion' => 'Apoyo en cocina.',
            'requisitos' => 'Experiencia básica.',
            'salario' => 50000,
            'tipoContrato' => 'tiempo completo',
            'ubicacion' => 'Málaga',
            'fechaPublicacion' => today()->toDateString(),
            'fechaLimite' => today()->addDays(10)->toDateString(),
            'idEmpresa' => $empresa->id,
        ]);
    }

    public function test_usuario_ve_su_menu_perfil_y_puede_abrir_sus_pantallas(): void
    {
        $usuario = $this->usuario();

        $this->actingAs($usuario, 'web')->get('/empleos')
            ->assertOk()
            ->assertSee('Mi perfil')
            ->assertSee('Mis calificaciones');

        $this->get(route('perfil.editar'))->assertOk()->assertSee('Editar perfil');
        $this->get(route('perfil.calificaciones'))->assertOk()->assertSee('Aún no tienes calificaciones');
    }

    public function test_empresa_gestiona_postulacion_y_califica_sin_poder_tomar_otra_oferta(): void
    {
        $empresa = $this->empresa();
        $persona = $this->usuario();
        $oferta = $this->oferta($empresa);
        $postulacion = Postulacion::create([
            'fecha' => today()->toDateString(),
            'estado' => 'Enviado',
            'idUsuario' => $persona->id,
            'idOferta' => $oferta->id,
        ]);

        $this->actingAs($empresa, 'empresa')
            ->get(route('Publico.misOfertas.postulantes', $oferta->id))
            ->assertOk()
            ->assertSee('Rechazar')
            ->assertSee('Aceptar');

        $this->patch(route('Publico.misOfertas.actualizarPostulante', $postulacion->id), ['estado' => 'Aceptado'])
            ->assertSessionHas('success');
        $this->patch(route('Publico.misOfertas.actualizarPostulante', $postulacion->id), ['estado' => 'Contratado'])
            ->assertSessionHas('success');
        $this->post(route('Publico.misOfertas.calificarPostulante', $postulacion->id), [
            'puntuacion' => 5,
            'comentario' => 'Buen trabajo.',
        ])->assertSessionHas('success');

        $this->actingAs($persona, 'web')->post(route('Publico.calificar', $postulacion->id), [
            'puntuacion' => 4,
            'comentario' => 'Buena experiencia.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('calificacion', [
            'idEmpresa' => $empresa->id,
            'idUsuarioCalificado' => $persona->id,
            'idPostulacion' => $postulacion->id,
            'tipoCalificador' => 'empresa',
            'puntuacion' => 5,
        ]);

        $this->get(route('perfil.calificaciones'))->assertOk()->assertSee('Calificación recibida');
        $this->actingAs($empresa, 'empresa')->get(route('perfil.calificaciones'))
            ->assertOk()
            ->assertSee('Calificación enviada');

        $this->post(route('Publico.misOfertas.calificarPostulante', $postulacion->id), [
            'puntuacion' => 4,
            'comentario' => 'Segundo intento.',
        ])->assertSessionHas('error');
    }

    public function test_edicion_de_perfil_no_permite_alterar_estado_de_la_cuenta(): void
    {
        $usuario = $this->usuario();

        $this->actingAs($usuario, 'web')->put(route('perfil.actualizar'), [
            'nombres' => 'Laura María',
            'apellidos' => 'Pérez',
            'fechaNacimiento' => '1995-01-01',
            'tipoDocumento' => 'CC',
            'numeroDocumento' => $usuario->numeroDocumento,
            'telefono' => '3000000001',
            'email' => $usuario->email,
            'estado' => 'inactivo',
        ])->assertSessionHas('success');

        $this->assertSame('activo', $usuario->fresh()->estado);
        $this->assertSame('Laura María', $usuario->fresh()->nombres);
    }

    public function test_empresa_puede_editar_su_perfil_sin_cambiar_el_estado(): void
    {
        $empresa = $this->empresa();

        $this->actingAs($empresa, 'empresa')->put(route('perfil.actualizar'), [
            'nombreEmpresa' => 'Acme Málaga Servicios',
            'nit' => $empresa->nit,
            'direccion' => 'Nueva dirección, Málaga',
            'email' => $empresa->email,
            'estado' => 'inactivo',
        ])->assertSessionHas('success');

        $this->assertSame('activo', $empresa->fresh()->estado);
        $this->assertSame('Nueva dirección, Málaga', $empresa->fresh()->direccion);
    }
}
