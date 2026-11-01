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

/* ===== Vista "Ofertas con sesión" (usuario) ===== */

    public function listarActivas(array $filtros, int $porPagina)
    {
        $consulta = Oferta::with(['empresa', 'usuario'])
            ->whereDate('fechaLimite', '>=', today())
            ->when($filtros['q'] ?? null, fn ($q, $v) => $q->where('titulo', 'like', "%{$v}%"))
            ->when($filtros['contrato'] ?? null, fn ($q, $v) => $q->where('tipoContrato', $v))
            ->when(($filtros['publica'] ?? null) === 'empresas', fn ($q) => $q->whereNotNull('idEmpresa'))
            ->when(($filtros['publica'] ?? null) === 'personas', fn ($q) => $q->whereNotNull('idUsuario'))
            ->when($filtros['categoria'] ?? null, function ($q, $idCategoria) {
                $q->whereIn('id', \App\Models\OfertaServicios::query()
                    ->select('idOferta')
                    ->whereHas('servicio', fn ($s) => $s->where('idCategoria', $idCategoria)));
            });

        match ($filtros['orden'] ?? 'recientes') {
            'antiguas' => $consulta->orderBy('fechaPublicacion')->orderBy('id'),
            'vencen'   => $consulta->orderBy('fechaLimite')->orderBy('id'),
            default    => $consulta->orderByDesc('fechaPublicacion')->orderByDesc('id'),
        };

        return $consulta->paginate($porPagina)->withQueryString();
    }

    /** Devuelve [idOferta => nombre de la categoría]. */
    public function categoriasPorOferta(array $idsOfertas): array
    {
        return \App\Models\OfertaServicios::with('servicio.categoria')
            ->whereIn('idOferta', $idsOfertas)
            ->get()
            ->groupBy('idOferta')
            ->map(fn ($filas) => optional($filas->first()->servicio?->categoria)->nombre)
            ->all();
    }

    public function listarCategorias()
    {
        return \App\Models\Categoria::orderBy('nombre')->get(['id', 'nombre']);
    }

    public function idsOfertasPostuladas(int $idUsuario): array
    {
        return \App\Models\Postulacion::where('idUsuario', $idUsuario)->pluck('idOferta')->all();
    }

    /** Devuelve ['Enviado' => n, 'Aceptado' => n, 'Rechazado' => n]. */
    public function contarPostulacionesPorEstado(int $idUsuario): array
    {
        return \App\Models\Postulacion::where('idUsuario', $idUsuario)
            ->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->all();
    }

    public function contarPostulantesPorRevisar(int $idUsuario): int
    {
        return \App\Models\Postulacion::where('estado', 'Enviado')
            ->whereHas('oferta', fn ($q) => $q->where('idUsuario', $idUsuario))
            ->count();
    }

    public function hojaDeVidaDe(int $idUsuario)
    {
        return \App\Models\HojaDeVida::where('idUsuario', $idUsuario)->latest('id')->first();
    }

    /** TEMPORAL: mientras no exista el login se usa el primer usuario registrado. */
    public function usuarioDePrueba()
    {
        return \App\Models\Usuario::first();
    }
}
