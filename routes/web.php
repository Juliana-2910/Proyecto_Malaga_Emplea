<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('roles', RolesController::class);
