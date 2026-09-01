<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\EmpresaController;


Route::resource('roles', RolesController::class);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');



Route::resource('categorias', CategoriaController::class);

Route::resource('empresas', EmpresaController::class);
