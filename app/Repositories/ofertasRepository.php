<?php

namespace App\Repositories;

use App\Models\Oferta;

class ofertasRepository
{
    public function listarTodos()
    {
        return Oferta::all();
    }

    public function guardar(array $datos)
    {
        Oferta::create($datos);
    }

    public function eliminar(int $id)
    {
        Oferta::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return Oferta::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $oferta = Oferta::findOrFail($id);

        unset($datos['fechaPublicacion']);

        $oferta->update($datos);
    }

    public function tienePostulaciones(int $id): bool
    {
        $oferta = Oferta::findOrFail($id);

        return $oferta->postulaciones()->exists();
    }

    public function listarDisponiblesParaPostular()
    {
        return Oferta::whereDate(
            'fechaLimite',
            '>=',
            now('America/Bogota')->toDateString()
        )->get();
    }

}
