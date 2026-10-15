<?php

namespace App\Repositories;

use App\Models\Categoria;

class categoriasRepository{

    public function listarTodos()
    {
        $categorias = Categoria::all();
        return $categorias;
    }

    public function guardar(array $datos)
    {
        Categoria::create($datos);
    }

    public function eliminar (int $id)
    {
        Categoria::destroy($id);
    }

    public function buscarPorId(int $id)
    {
        $categoria = Categoria::findOrFail($id);
        return $categoria;
    }

    public function actualizar(int $id, array $datos)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($datos);
    }
}

