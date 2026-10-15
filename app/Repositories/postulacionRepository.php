<?php

namespace App\Repositories;

use App\Models\Postulacion;

class postulacionRepository
{
    public function listarTodos()
    {
        return Postulacion::all();
    }

    public function guardar(array $datos)
    {
        Postulacion::create($datos);
    }

    public function eliminar(int $id)
    {
        Postulacion::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return Postulacion::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $postulacion = Postulacion::findOrFail($id);

        $postulacion->update($datos);
    }
}