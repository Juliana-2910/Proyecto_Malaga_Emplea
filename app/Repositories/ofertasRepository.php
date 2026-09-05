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

        $oferta->update($datos);
    }
}