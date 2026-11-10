<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HojaDeVidaController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\OfertaServiciosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfertaPublicaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\Seguridad\AuthController;


    Route::get('/', [HomeController::class, 'index'])->name('Publico.inicio');
    
    Route::post('/registro/usuario', [AuthController::class, 'registrarUsuario'])->name('registro.usuario');
    Route::post('/registro/empresa', [AuthController::class, 'registrarEmpresa'])->name('registro.empresa');

Route::middleware('auth:web,empresa')->group(function () {

    Route::get('/empleos', [OfertaPublicaController::class, 'index'])->name('Publico.ofertas');
    Route::post('/empleos/{id}/postular', [OfertaPublicaController::class, 'postular'])->whereNumber('id')->name('Publico.postular');
    Route::delete('/empleos/postulaciones/{id}', [OfertaPublicaController::class, 'cancelarPostulacion'])->whereNumber('id')->name('Publico.cancelarPostulacion');
    Route::post('/empleos/hoja-de-vida', [OfertaPublicaController::class, 'guardarHojaDeVida'])->name('Publico.guardarHojaDeVida');
    Route::post('/empleos/publicar', [OfertaPublicaController::class, 'guardarOferta'])->name('Publico.guardarOferta');
    Route::get('/mis-postulaciones', [OfertaPublicaController::class, 'misPostulaciones'])->name('Publico.postulaciones');
    Route::post('/mis-postulaciones/{id}/calificar', [OfertaPublicaController::class, 'calificar'])->whereNumber('id')->name('Publico.calificar');
    Route::get('/mis-ofertas', [OfertaPublicaController::class, 'misOfertas'])->name('Publico.misOfertas');
    Route::put('/mis-ofertas/{id}', [OfertaPublicaController::class, 'actualizarOferta'])->whereNumber('id')->name('Publico.actualizarOferta');
    Route::get('/mis-ofertas/{id}/postulantes', [OfertaPublicaController::class, 'postulantes'])->whereNumber('id')->name('Publico.misOfertas.postulantes');

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

    Route::get('/empresas-con-ofertas',[EmpresaController::class, 'empresasConOfertas'])->name('empresas.conOfertas');
    Route::get('/usuarios-con-postulaciones',[UsuarioController::class, 'usuariosConPostulaciones'])->name('usuarios.conPostulaciones');
    Route::get('/usuarios-sin-postulaciones',[UsuarioController::class, 'usuariosSinPostulaciones'])->name('usuarios.sinPostulaciones');
    Route::get('/ofertas-sobre-promedio-postulaciones', [OfertaController::class, 'ofertasSobrePromedioPostulaciones'])->name('ofertas.sobrePromedioPostulaciones');
    Route::get('/ofertas-con-servicios', [OfertaController::class, 'ofertasConServicios'])->name('ofertas.conServicios');
    Route::get('/ofertas-sin-servicios', [OfertaController::class, 'ofertasSinServicios'])->name('ofertas.sinServicios');
    Route::get('/reputacion-empresas', [CalificacionController::class, 'reputacionEmpresas'])->name('calificacion.reputacionEmpresas');
    Route::get('/reputacion-usuarios', [CalificacionController::class, 'reputacionUsuarios'])->name('calificacion.reputacionUsuarios');


});
