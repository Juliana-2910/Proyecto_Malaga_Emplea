<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fechaNacimiento');
            $table->enum('tipoDocumento', ['CC', 'CE', 'PPT','PEP', 'PASAPORTE']);
            $table->string('numeroDocumento')->unique();
            $table->string('correoElectronico')->unique();
            $table->string('password');
            $table->string('telefono');
            $table->date('fechaRegistro');
            $table->enum('estado', ['Activo', 'Inactivo']);
            $table->unsignedBigInteger('idRol');
            $table->foreign('idRol')->references('id')->on('roles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
