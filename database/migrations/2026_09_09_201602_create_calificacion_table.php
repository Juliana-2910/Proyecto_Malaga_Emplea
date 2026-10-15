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
            $table->string('puntuacion');
            $table->text('comentario');
            $table->date('fecha');
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idEmpresa');
            $table->foreign('idUsuario')->references('id')->on('usuarios');
            $table->foreign('idEmpresa')->references('id')->on('empresas');
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
