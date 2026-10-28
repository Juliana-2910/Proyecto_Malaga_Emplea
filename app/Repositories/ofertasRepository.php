<?php

namespace App\Repositories;

use App\Models\Oferta;
use Illuminate\Support\Facades\DB;

class ofertasRepository
{
    public function listarTodos()
    {
        return Oferta::all();
    }

    public function guardar(array $datos)
    {
        Oferta::create($datos);
    }

    public function eliminar(int $id)
    {
        Oferta::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return Oferta::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $oferta = Oferta::findOrFail($id);

        unset($datos['fechaPublicacion']);

        $oferta->update($datos);
    }

    public function tienePostulaciones(int $id): bool
    {
        $oferta = Oferta::findOrFail($id);

        return $oferta->postulaciones()->exists();
    }

    public function listarDisponiblesParaPostular()
    {
        return Oferta::whereDate(
            'fechaLimite',
            '>=',
            now('America/Bogota')->toDateString()
        )->get();
    }


    // Subconsulta: ofertas con más postulaciones que el promedio
    public function listarOfertasSobrePromedioPostulaciones()
    {
        return DB::select("
            SELECT
                o.id,
                o.titulo,
                (
                    SELECT COUNT(*)
                    FROM postulacion AS p
                    WHERE p.idOferta = o.id
                ) AS totalPostulaciones
            FROM ofertas AS o
            WHERE (
                SELECT COUNT(*)
                FROM postulacion AS p
                WHERE p.idOferta = o.id
            ) > (
                SELECT AVG(conteos.total)
                FROM (
                    SELECT COUNT(*) AS total
                    FROM postulacion
                    GROUP BY idOferta
                ) AS conteos
            )
        ");
    }

    // Subconsulta: ofertas que tienen servicios asociados
    public function listarOfertasConServicios()
    {
        return DB::select("
            SELECT o.id, o.titulo
            FROM ofertas AS o
            WHERE EXISTS (
            SELECT 1
            FROM ofertaServicios AS os
            WHERE os.idOferta = o.id
            )
        ");
    }

    // Subconsulta: ofertas que no tienen servicios asociados
    public function listarOfertasSinServicios()
{
    return DB::select("
        SELECT o.id, o.titulo
        FROM ofertas AS o
        WHERE NOT EXISTS (
            SELECT 1
            FROM ofertaServicios AS os
            WHERE os.idOferta = o.id
        )
    ");
}

}
