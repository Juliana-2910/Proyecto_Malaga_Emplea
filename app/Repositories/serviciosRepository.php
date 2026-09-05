<?php

namespace App\Repositories;

use App\Models\Servicios;

class serviciosRepository{

    public function listarTodos()
    {
        $servicios = Servicios::all();
        return $servicios;
    }

    public function guardar(array $datos)
    {
        Servicios::create($datos);
    }

    public function eliminar (int $id)
    {
        Servicios::destroy($id);
    }

    public function buscarPorId(int $id)
    {
        $servicio = Servicios::findOrFail($id);
        return $servicio;
    }

    public function actualizar(int $id, array $datos)
    {
        $servicio = Servicios::findOrFail($id);
        $servicio->update($datos);
    }
}

