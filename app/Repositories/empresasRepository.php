<?php

namespace App\Repositories;

use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class empresasRepository{

   public function listarTodos()
   {
        $empresas = Empresa::all();

        return $empresas;
    }

    public function guardar(array $datos)
    {
        $datos['password'] = Hash::make($datos['password']);

        return Empresa::create($datos);
    }

    public function eliminar(int $id)
    {
        return Empresa::destroy($id);
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

        return $empresa->update($datos);
    }

    // Subconsulta: empresas que tienen ofertas
    public function listarEmpresasConOfertas()
    {
        return DB::select("
            SELECT id, nombreEmpresa
            FROM empresas
            WHERE id IN (
                SELECT idEmpresa
                FROM ofertas
            )
        ");
    }

}