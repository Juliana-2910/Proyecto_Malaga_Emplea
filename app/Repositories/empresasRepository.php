<?php

namespace App\Repositories;

use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;

class empresasRepository{

   public function listarTodos()
   {
        $empresas = Empresa::all();

        return $empresas;
    }

    public function guardar(array $datos)
    {
        $datos['password'] = Hash::make($datos['password']);

        Empresa::create($datos);
    }

    public function eliminar(int $id)
    {
        Empresa::destroy($id);
    }

    public function buscarporid(int $id)
    {
        $empresa = Empresa::findOrFail($id);

        return $empresa;
    }

    public function actualizar(int $id, array $datos)
    {
    $empresa = Empresa::findOrFail($id);

        if (empty($datos['password'])) {
            unset($datos['password']);
        } else {
            $datos['password'] = Hash::make($datos['password']);
        }

        $empresa->update($datos);
    }


}