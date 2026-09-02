<?php

namespace App\Repositories;

use App\Models\Usuario;

class usuariosRepository{

    public function listarTodos()
    {
        return Usuario::with('rol')->get();
    }

    public function guardar(array $datos)
    {
        Usuario::create($datos);
    }

    public function eliminar (int $id)
    {
        Usuario::destroy($id);
    }

    public function buscarPorId(int $id)
    {
        $usuario = Usuario::findOrFail($id);
        return $usuario;
    }

    public function actualizar(int $id, array $datos)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->update($datos);
    }
}
