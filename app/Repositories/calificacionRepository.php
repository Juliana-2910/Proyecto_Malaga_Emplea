<?php

namespace App\Repositories;

use App\Models\Calificacion;

class calificacionRepository{

    public function listarTodos()
    {
        return Calificacion::all();
    }

    public function guardar(array $datos)
    {
        return Calificacion::create($datos);
    }

    public function eliminar (int $id)
    {
        $calificacion = Calificacion::findOrFail($id);
        return $calificacion->delete();
    }

    public function buscarPorId(int $id)
    {
        return Calificacion::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $calificacion = Calificacion::FindOrFail($id);
        $calificacion->update($datos);
        return $calificacion;
    }
}
