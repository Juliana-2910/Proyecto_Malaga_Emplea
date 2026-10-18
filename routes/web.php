<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HojaDeVidaController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\OfertaServiciosController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\PostulacionController;


Route::get('/adm', [DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('roles', RolesController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('empresas', EmpresaController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('ofertas', OfertaController::class);
Route::resource('hojaDeVida', HojaDeVidaController::class);
Route::resource('servicios', ServiciosController::class);
Route::resource('postulacion', PostulacionController::class);
Route::resource('calificacion', CalificacionController::class);
Route::resource('ofertaServicios', OfertaServiciosController::class);

Route::get('/', [HomeController::class, 'index'])->name('Publico.inicio');

Route::get('/empresas-con-ofertas',[EmpresaController::class, 'empresasConOfertas'])->name('empresas.conOfertas');
Route::get('/usuarios-con-postulaciones',[UsuarioController::class, 'usuariosConPostulaciones'])->name('usuarios.conPostulaciones');
Route::get('/usuarios-sin-postulaciones',[UsuarioController::class, 'usuariosSinPostulaciones'])->name('usuarios.sinPostulaciones');

