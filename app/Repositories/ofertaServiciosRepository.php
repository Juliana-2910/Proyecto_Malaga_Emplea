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
        return OfertaServicios::create($datos);
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

    public function actualizarPorOferta(int $idOferta, int $idServicio)
    {
        return OfertaServicios::updateOrCreate(['idOferta' => $idOferta],['idServicio' => $idServicio]);
    }
}
