<?php

namespace App\Repositories;

use App\Models\Calificacion;
use Illuminate\Support\Facades\DB;

class calificacionRepository{

    public function listarTodos()
    {
        return Calificacion::all();
    }

    public function guardar(array $datos)
    {
        return Calificacion::create($datos);
    }

    public function eliminar (int $id)
    {
        $calificacion = Calificacion::findOrFail($id);
        return $calificacion->delete();
    }

    public function buscarPorId(int $id)
    {
        return Calificacion::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $calificacion = Calificacion::FindOrFail($id);
        $calificacion->update($datos);
        return $calificacion;
    }

    // Reputación promedio de las empresas
    public function listarReputacionEmpresas()
    {
        return DB::select("
             SELECT
                 e.id,
                 e.nombreEmpresa,
                 (
                    SELECT AVG(c.puntuacion)
                    FROM calificacion AS c
                    WHERE c.idEmpresa = e.id
                    AND c.tipoCalificador = 'usuario'
                 ) AS reputacion,
                 (
                    SELECT COUNT(*)
                    FROM calificacion AS c
                    WHERE c.idEmpresa = e.id
                    AND c.tipoCalificador = 'usuario'
                 ) AS totalCalificaciones
                    FROM empresas AS e
                    WHERE EXISTS (
                    SELECT 1
                    FROM calificacion AS c
                    WHERE c.idEmpresa = e.id
                    AND c.tipoCalificador = 'usuario'
                )
        ");
    }

    // Reputación promedio de los usuarios
    public function listarReputacionUsuarios()
    {
        return DB::select("
                SELECT
                u.id,
                u.nombres,
                u.apellidos,
            (
                SELECT AVG(c.puntuacion)
                FROM calificacion AS c
                WHERE c.idUsuario = u.id
                  AND c.tipoCalificador = 'empresa'
            ) AS reputacion,
            (
                SELECT COUNT(*)
                FROM calificacion AS c
                WHERE c.idUsuario = u.id
                  AND c.tipoCalificador = 'empresa'
            ) AS totalCalificaciones
                FROM usuarios AS u
                WHERE EXISTS (
                SELECT 1
                FROM calificacion AS c
                WHERE c.idUsuario = u.id
                AND c.tipoCalificador = 'empresa'
        )
        ");
    }
}
