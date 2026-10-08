<?php

namespace App\Repositories;

use App\Models\HojaDeVida;

class hojaDeVidaRepository{

    public function listarTodos()
    {
        return HojaDeVida::all();
    }

    public function guardar(array $datos)
    {
        return HojaDeVida::create($datos);
    }

    public function eliminar(int $id)
    {
        $hojaDeVida = HojaDeVida::findOrFail($id);
        $hojaDeVida->delete();
    }

    public function buscarPorId(int $id)
    {
        return HojaDeVida::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $hojaDeVida = HojaDeVida::findOrFail($id);
        $hojaDeVida->update($datos);
    }
}
