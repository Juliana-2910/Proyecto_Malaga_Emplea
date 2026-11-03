<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HojaDeVidaController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\OfertaServiciosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\PostulacionController;



Route::middleware('auth:web,empresa')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('roles', RolesController::class)->middleware('can:gestionar seguridad');
    Route::resource('categorias', CategoriaController::class)->middleware('modulo:categorias');
    Route::resource('empresas', EmpresaController::class)->middleware('modulo:empresas');
    Route::resource('usuarios', UsuarioController::class)->middleware('modulo:usuarios');
    Route::resource('ofertas', OfertaController::class)->middleware('modulo:ofertas');
    Route::resource('hojaDeVida', HojaDeVidaController::class)->middleware('modulo:hojadevida');
    Route::resource('servicios', ServiciosController::class)->middleware('modulo:servicios');
    Route::resource('postulacion', PostulacionController::class)->middleware('modulo:postulacion');
    Route::resource('calificacion', CalificacionController::class)->middleware('modulo:calificacion');
    Route::resource('ofertaServicios', OfertaServiciosController::class)->middleware('modulo:ofertaservicios');
});
