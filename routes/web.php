<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HojaDeVidaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\EmpresaController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');


Route::resource('roles', RolesController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('empresas', EmpresaController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('hojaDeVida', HojaDeVidaController::class);
