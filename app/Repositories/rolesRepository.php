<?php

namespace App\Repositories;

use App\Models\Roles;

class rolesRepository{

    public function listarTodos()
    {
        return Roles::where('guard_name', 'web')->get();
    }

    public function guardar(array $datos)
    {
        $datos['guard_name'] = 'web';

        return Roles::create($datos);
    }

    public function eliminar(int $id)
    {
        $rol = Roles::where('guard_name', 'web')
            ->findOrFail($id);

        return $rol->delete();
    }

    public function buscarporid(int $id)
    {
        return Roles::where('guard_name', 'web')
            ->findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $rol = $this->buscarporid($id);

        unset($datos['guard_name']);

        return $rol->update($datos);
    }


}
