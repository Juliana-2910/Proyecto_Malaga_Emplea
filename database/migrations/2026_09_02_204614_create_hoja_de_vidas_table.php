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
        Schema::create('hojaDeVida', function (Blueprint $table) {
            $table->id();
            $table->string('ubicacion');
            $table->enum('nivelEducativo', ['Basica Primaria', 'Basica Secundaria', 'Tecnico', 'Tecnologo', 'Profesional']);
            $table->text('perfilProfesional');
            $table->text('experienciaLaboral');
            $table->timestamp('fechaActualizacion');
            $table->string('archivoCV', 255);
            $table->unsignedBigInteger('idUsuario');
            $table->foreign('idUsuario')->references('id')->on('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hojaDeVida');
    }
};
