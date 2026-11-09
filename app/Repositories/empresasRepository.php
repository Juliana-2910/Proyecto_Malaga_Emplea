<?php

namespace App\Repositories;

use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class empresasRepository{

public function listarTodos()
{
        return Empresa::all();
    }

    public function guardar(array $datos)
    {
        return Empresa::create($datos);
    }

    public function eliminar(int $id)
    {
        return Empresa::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return Empresa::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
    $empresa = Empresa::findOrFail($id);

        if (empty($datos['password'])) {
            unset($datos['password']);
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
