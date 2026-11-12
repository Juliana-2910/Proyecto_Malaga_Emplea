<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\Usuario;
use Database\Seeders\RolEmpresaSeeder;
use Database\Seeders\PermisosEmpresaSeeder;
use Database\Seeders\SeguridadSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class EmpresaAccesoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SeguridadSeeder::class);
        $this->seed(RolEmpresaSeeder::class);
        $this->artisan('seguridad:modulo', ['nombres' => ['ofertas', 'usuarios', 'empresas']]);
        $this->seed(PermisosEmpresaSeeder::class);
    }

    private function admin(): Usuario
    {
        return Usuario::where('email', 'admin@admin.com')->firstOrFail();
    }

    private function crearEmpresa(string $correo = 'e@e.com', string $nit = '900', string $estado = 'activo'): Empresa
    {
        return Empresa::create([
            'nombreEmpresa' => 'Acme Ltda', 'fotoPerfil' => 'x.png', 'nit' => $nit, 'direccion' => 'Calle 1',
            'estado' => $estado, 'email' => $correo, 'password' => Hash::make('12345678'),
        ]);
    }

    private function loginEmpresa(string $correo = 'e@e.com'): void
    {
        $this->post(route('login.store'), ['tipo' => 'empresa', 'email' => $correo, 'password' => '12345678'])
            ->assertSessionHasNoErrors();
    }

    public function test_el_rol_empresa_existe_activo_y_protegido(): void
    {
        $rol = Role::findByName('empresa', 'web');
        $this->assertTrue((bool) $rol->activo);

        $this->actingAs($this->admin(), 'web');
        $this->put(route('seguridad.roles.update', $rol), ['name' => 'otra', 'activo' => '1'])->assertSessionHas('error');
        $this->delete(route('seguridad.roles.destroy', $rol))->assertSessionHas('error');
        $this->assertModelExists($rol);
    }

    public function test_la_empresa_que_ya_existia_recibe_el_rol_con_el_seeder(): void
    {
        $existente = Empresa::withoutEvents(fn () => $this->crearEmpresa());
        $this->assertFalse($existente->fresh()->hasRole('empresa'));

        $this->seed(RolEmpresaSeeder::class);
        $this->seed(RolEmpresaSeeder::class);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->assertTrue($existente->fresh()->hasRole('empresa'));
        $this->assertSame(1, DB::table(config('permission.table_names.model_has_roles'))->where('model_type', Empresa::class)->count());
    }

    public function test_una_empresa_nueva_recibe_el_rol_sola(): void
    {
        $this->assertSame(['empresa'], $this->crearEmpresa()->getRoleNames()->all());
    }

    public function test_login_de_empresa_y_de_usuario_y_logout(): void
    {
        $empresa = $this->crearEmpresa();

        $this->get(route('login'))->assertOk()->assertSee('Persona natural')->assertSee('Empresa')->assertSee('¿Cómo deseas ingresar?');

        $this->post(route('login.store'), ['tipo' => 'empresa', 'email' => 'e@e.com', 'password' => '12345678'])
            ->assertRedirect(route('Publico.misOfertas'));
        $this->assertAuthenticatedAs($empresa, 'empresa');
        $this->assertGuest('web');

        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest('empresa');

        $this->post(route('login.store'), ['tipo' => 'usuario', 'email' => 'admin@admin.com', 'password' => '12345678'])
            ->assertRedirect();
        $this->assertAuthenticatedAs($this->admin(), 'web');
    }

    public function test_ingresar_con_otra_guardia_limpia_la_sesion_anterior(): void
    {
        $this->crearEmpresa();
        $this->loginEmpresa();
        $this->assertAuthenticated('empresa');

        $admin = $this->admin();
        $ingresoAdmin = app(\App\Services\Seguridad\AuthService::class)->autenticar(
            config('seguridad.admin.email'),
            config('seguridad.admin.password'),
            false,
            'usuario'
        );

        $this->assertTrue($ingresoAdmin);
        $this->assertGuest('empresa');
        $this->assertAuthenticatedAs($admin, 'web');
    }

    public function test_el_tipo_de_cuenta_importa_y_las_claves_malas_fallan(): void
    {
        $this->crearEmpresa();

        $this->post(route('login.store'), ['tipo' => 'empresa', 'email' => 'admin@admin.com', 'password' => '12345678'])
            ->assertSessionHasErrors('email');
        $this->post(route('login.store'), ['tipo' => 'usuario', 'email' => 'e@e.com', 'password' => '12345678'])
            ->assertSessionHasErrors('email');
        $this->post(route('login.store'), ['tipo' => 'empresa', 'email' => 'e@e.com', 'password' => 'mala'])
            ->assertSessionHasErrors('email');
        $this->assertGuest('empresa');
    }

    public function test_una_empresa_inactiva_no_puede_entrar(): void
    {
        $this->crearEmpresa('i@i.com', '901', 'inactivo');

        $this->post(route('login.store'), ['tipo' => 'empresa', 'email' => 'i@i.com', 'password' => '12345678'])
            ->assertSessionHasErrors(['email' => 'Tu cuenta está inactiva. Comunícate con el administrador.']);
        $this->assertGuest('empresa');
    }

    public function test_seguridad_muestra_y_cambia_el_estado_de_personas_y_empresas(): void
    {
        $usuario = Usuario::create([
            'nombres' => 'Laura',
            'apellidos' => 'Pérez',
            'fechaNacimiento' => '1990-01-01',
            'tipoDocumento' => 'CC',
            'numeroDocumento' => '123456',
            'telefono' => '3000000000',
            'email' => 'laura@example.com',
            'password' => Hash::make('12345678'),
            'estado' => 'inactivo',
        ]);
        $empresa = $this->crearEmpresa('inactiva@acme.com', '905', 'inactivo');

        $this->actingAs($this->admin(), 'web');
        $this->get(route('seguridad.cuentas.index'))
            ->assertOk()
            ->assertSee('Laura Pérez')
            ->assertSee('Acme Ltda')
            ->assertSee('Inactivo');

        $this->patch(route('seguridad.cuentas.estado', ['tipo' => 'usuario', 'id' => $usuario->id]))
            ->assertSessionHas('success');
        $this->assertSame('activo', $usuario->fresh()->estado);

        $this->patch(route('seguridad.cuentas.estado', ['tipo' => 'empresa', 'id' => $empresa->id]))
            ->assertSessionHas('success');
        $this->assertSame('activo', $empresa->fresh()->estado);

        $this->patch(route('seguridad.cuentas.estado', ['tipo' => 'usuario', 'id' => $usuario->id]))
            ->assertSessionHas('success');
        $this->assertSame('inactivo', $usuario->fresh()->estado);
    }

    public function test_estado_de_usuario_con_mayusculas_se_acepta_al_ingresar_y_la_sesion_se_cierra_al_inactivar(): void
    {
        $usuario = Usuario::create([
            'nombres' => 'Caso',
            'apellidos' => 'Legado',
            'fechaNacimiento' => '1990-01-01',
            'tipoDocumento' => 'CC',
            'numeroDocumento' => '123457',
            'telefono' => '3000000000',
            'email' => 'legada@example.com',
            'password' => Hash::make('12345678'),
            'estado' => 'Activo',
        ]);

        $this->post(route('login.store'), [
            'tipo' => 'usuario',
            'email' => 'legada@example.com',
            'password' => '12345678',
        ])->assertRedirect();

        $this->get('/dashboard')->assertOk();

        DB::table('usuarios')->where('id', $usuario->id)->update(['estado' => 'Inactivo']);
        $this->app['auth']->forgetGuards();

        $this->get('/dashboard')
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');
        $this->assertGuest('web');
    }

    public function test_la_sesion_de_empresa_se_cierra_si_el_administrador_la_inactiva(): void
    {
        $empresa = $this->crearEmpresa('sesion@acme.com', '909');
        $this->loginEmpresa('sesion@acme.com');
        $this->get('/dashboard')->assertOk();

        DB::table('empresas')->where('id', $empresa->id)->update(['estado' => 'inactivo']);
        $this->app['auth']->forgetGuards();

        $this->get('/dashboard')
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');
        $this->assertGuest('empresa');
    }

    public function test_registro_publico_activa_la_empresa_y_el_panel_respeta_el_estado_elegido(): void
    {
        $this->postJson(route('registro.empresa'), [
            'nombreEmpresa' => 'Registro público',
            'nit' => '907',
            'direccion' => 'Calle 2',
            'email' => 'registro@publico.com',
            'password' => '12345678',
        ])->assertCreated();

        $this->assertDatabaseHas('empresas', [
            'email' => 'registro@publico.com',
            'estado' => 'activo',
        ]);

        $this->actingAs($this->admin(), 'web');
        $this->post(route('empresas.store'), [
            'nombreEmpresa' => 'Registro administrativo',
            'nit' => '908',
            'direccion' => 'Calle 3',
            'email' => 'registro@admin.com',
            'password' => '12345678',
            'estado' => 'inactivo',
        ])->assertRedirect(route('empresas.index'));

        $this->assertDatabaseHas('empresas', [
            'email' => 'registro@admin.com',
            'estado' => 'inactivo',
        ]);
    }

    public function test_la_empresa_entra_al_dashboard_con_su_nombre_y_sin_enlaces_de_mas(): void
    {
        $this->crearEmpresa();
        $this->loginEmpresa();

        $this->get('/dashboard')->assertOk()
            ->assertSee('Acme Ltda')
            ->assertSee(route('dashboard.index'))
            ->assertDontSee(route('usuarios.index'))
            ->assertDontSee(route('seguridad.permisos.index'));
    }

    public function test_sin_permisos_la_empresa_recibe_403_y_con_permisos_entra(): void
    {
        $this->crearEmpresa();
        $this->loginEmpresa();
        Role::findByName('empresa', 'web')->syncPermissions([]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->app['auth']->forgetGuards();

        $this->get('/ofertas')->assertForbidden();
        $this->get('/usuarios')->assertForbidden();
        $this->get('/seguridad/roles')->assertForbidden();

        Role::findByName('empresa', 'web')->syncPermissions(['ver ofertas']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->app['auth']->forgetGuards();

        $this->get('/ofertas')->assertOk();
        $this->get('/ofertas/create')->assertForbidden();
        $this->get('/usuarios')->assertForbidden();
        $this->get('/dashboard')->assertOk()->assertSee(route('ofertas.index'))->assertDontSee(route('usuarios.index'));
    }

    public function test_el_admin_asigna_permisos_al_rol_empresa_desde_el_panel(): void
    {
        $this->actingAs($this->admin(), 'web');
        $rol = Role::findByName('empresa', 'web');

        $this->get(route('seguridad.roles.edit', $rol))->assertOk()->assertSee('ofertas');
        $this->put(route('seguridad.roles.update', $rol), [
            'name' => 'empresa', 'activo' => '1', 'permissions' => ['ver ofertas', 'crear ofertas', 'editar ofertas'],
        ])->assertRedirect(route('seguridad.roles.index'));

        $this->assertEqualsCanonicalizing(
            ['ver ofertas', 'crear ofertas', 'editar ofertas'],
            $rol->fresh()->permissions->pluck('name')->all()
        );

        $this->app['auth']->forgetGuards();
        $this->crearEmpresa();
        $this->loginEmpresa();
        $this->get('/ofertas')->assertOk();
        $this->get('/ofertas/create')->assertOk();
    }

    public function test_desactivar_el_rol_empresa_quita_los_permisos(): void
    {
        $rol = Role::findByName('empresa', 'web');
        $rol->syncPermissions(['ver ofertas']);
        $this->crearEmpresa();
        $this->loginEmpresa();
        $this->get('/ofertas')->assertOk();

        $rol->update(['activo' => false]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->app['auth']->forgetGuards();

        $this->get('/ofertas')->assertForbidden();
    }

    public function test_el_administrador_sigue_accediendo_a_todo(): void
    {
        $this->actingAs($this->admin(), 'web');

        $this->get('/dashboard')->assertOk();
        $this->get('/ofertas')->assertOk();
        $this->get('/usuarios')->assertOk();
        $this->get('/empresas')->assertOk();
        $this->get(route('seguridad.roles.index'))->assertOk();
        $this->get(route('seguridad.permisos.index'))->assertOk()->assertSee('ofertas');
    }

    public function test_el_conteo_de_roles_incluye_empresas_y_bloquea_borrar_el_rol(): void
    {
        $this->crearEmpresa('a@a.com', '902');
        $this->crearEmpresa('b@b.com', '903');

        $roles = app(\App\Repositories\Seguridad\RolRepository::class)->listar();
        $this->assertSame(2, $roles->firstWhere('name', 'empresa')->users_count);

        $rolTemporal = Role::create(['name' => 'temporal', 'guard_name' => 'web', 'activo' => true]);
        $this->crearEmpresa('c@c.com', '904')->assignRole('temporal');
        $this->actingAs($this->admin(), 'web');
        $this->delete(route('seguridad.roles.destroy', $rolTemporal))->assertSessionHas('error');
        $this->assertModelExists($rolTemporal);
    }

    public function test_invitado_va_al_login(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get('/ofertas')->assertRedirect(route('login'));
    }
}
