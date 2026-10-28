<?php

namespace App\Repositories;

use App\Models\HojaDeVida;

class hojaDeVidaRepository
{
    public function listarTodos()
    {
        return HojaDeVida::all();
    }

    public function guardar(array $datos)
    {
        return HojaDeVida::create($datos);
    }

    public function buscarPorId(int $id)
    {
        return HojaDeVida::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $hojaDeVida = $this->buscarPorId($id);
        $hojaDeVida->update($datos);
    }

    public function eliminar(int $id)
    {
        $hojaDeVida = $this->buscarPorId($id);
        $hojaDeVida->delete();
    }

    public function existePorUsuario(int $idUsuario): bool
    {
        return HojaDeVida::where('idUsuario', $idUsuario)->exists();
    }
}
