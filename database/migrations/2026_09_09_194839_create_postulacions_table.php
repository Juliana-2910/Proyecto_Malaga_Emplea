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
        Schema::create('postulacion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->enum('estado', ['Enviado', 'Aceptado', 'Rechazado']);
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idOferta');

            $table->foreign('idUsuario')
            ->references('id')
            ->on('usuarios');

            $table->foreign('idOferta')
            ->references('id')
            ->on('ofertas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulacion');
    }
};
