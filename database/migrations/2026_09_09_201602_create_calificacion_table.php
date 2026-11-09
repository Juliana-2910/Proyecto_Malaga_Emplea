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
        Schema::create('calificacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('puntuacion');
            $table->text('comentario');
            $table->date('fecha');
            $table->unsignedBigInteger('idUsuario')->nullable();          // persona natural que califica
            $table->unsignedBigInteger('idEmpresa')->nullable();          // empresa que califica
            $table->unsignedBigInteger('idUsuarioCalificado')->nullable(); // persona que recibe la calificación
            $table->unsignedBigInteger('idEmpresaCalificada')->nullable(); // empresa que recibe la calificación
            $table->unsignedBigInteger('idPostulacion');                  // contratación relacionada
            $table->enum('tipoCalificador', ['usuario', 'empresa']);
            $table->foreign('idUsuario')->references('id')->on('usuarios');
            $table->foreign('idEmpresa')->references('id')->on('empresas');
            $table->foreign('idUsuarioCalificado')->references('id')->on('usuarios');
            $table->foreign('idEmpresaCalificada')->references('id')->on('empresas');
            $table->foreign('idPostulacion')->references('id')->on('postulacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacion');
    }
};
