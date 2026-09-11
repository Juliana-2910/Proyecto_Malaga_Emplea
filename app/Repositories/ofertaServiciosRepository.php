<?php

namespace App\Repositories;

use App\Models\OfertaServicios;

class ofertaServiciosRepository
{
    public function listarTodos()
    {
        return OfertaServicios::all();
    }

    public function guardar(array $datos)
    {
        OfertaServicios::create($datos);
    }

    public function eliminar(int $id)
    {
        OfertaServicios::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return OfertaServicios::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $postulacion = OfertaServicios::findOrFail($id);

        $postulacion->update($datos);
    }
}
