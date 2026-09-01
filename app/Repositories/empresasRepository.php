<?php

namespace App\Repositories;

use App\Models\Empresa;

class empresasRepository{

   public function listarTodos()
   {
        $empresas = Empresa::all();
        return $empresas;
    }

    public function guardar(array $datos)
    {
        Empresa::create($datos);
    }

    public function eliminar(int $id)
    {
        Empresa::destroy($id);
    }

    public function buscarporid(int $id)
    {
        $empresas = Empresa::findOrFail($id);
        return $empresas;
    }

    public function actualizar(int $id, array $datos)
    {
        $empresas = Empresa::findOrFail($id);
        $empresas->update($datos);
    }


}