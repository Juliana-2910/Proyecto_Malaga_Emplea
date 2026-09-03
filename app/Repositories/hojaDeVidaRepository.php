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
        HojaDeVida::create($datos);
    }

    public function eliminar (int $id)
    {
        HojaDeVida::destroy($id);
    }

    public function buscarPorId(int $id)
    {
        $hojaDeVida = HojaDeVida::findOrFail($id);
        return $hojaDeVida;
    }

    public function actualizar(int $id, array $datos)
    {
        $hojaDeVida = HojaDeVida::findOrFail($id);
        $hojaDeVida->update($datos);
    }
}
