<?php

namespace App\Repositories;

use App\Models\Roles;

class rolesRepository{

   public function listarTodos()
   {
        $roles = Roles::all();
        return $roles;
    }

    public function guardar(array $datos)
    {
        Roles::create($datos);
    }

    public function eliminar(int $id)
    {
        Roles::destroy($id);
    }

    public function buscarporid(int $id)
    {
        $roles = Roles::findOrFail($id);
        return $roles;
    }

    public function actualizar(int $id, array $datos)
    {
        $roles = Roles::findOrFail($id);
        $roles->update($datos);
    }


}
