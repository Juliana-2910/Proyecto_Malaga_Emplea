<?php

namespace App\Repositories;

use App\Models\Usuario;

class usuariosRepository{

    public function listarTodos()
    {
        return Usuario::with('roles')->get();
    }

    public function listarUsuarios()
    {
        return Usuario::with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'usuario'); // Cambiado 'roles' por 'name'
            })
            ->get();
    }

    public function guardar(array $datos)
    {
        
        Usuario::create($datos);
    }

    public function eliminar (int $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
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
