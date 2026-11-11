<?php

namespace App\Repositories;

use App\Models\Oferta;
use App\Models\OfertaServicios;
use App\Models\Categoria;
use App\Models\Postulacion;
use App\Models\HojaDeVida;
use App\Models\Servicios;
use App\Models\Usuario;
use App\Models\Calificacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ofertasRepository
{
    public function listarTodos()
    {
        return Oferta::all();
    }

    public function guardar(array $datos)
    {
        return Oferta::create($datos);
    }

    public function eliminar(int $id)
    {
        Oferta::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return Oferta::with(['ofertaServicio.servicio.categoria'])->findOrFail($id);
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
            ->whereDate('fechaLimite', '>=', now('America/Bogota')->toDateString()) //Ofertas activas (no vencidas) //
            ->whereDoesntHave('postulaciones', function ($q) {$q->where('estado', 'Contratado');}) //Ocultar ofertas que ya tienen un postulante contratado //
            ->when($filtros['q'] ?? null, fn ($q, $v) => $q->where('titulo', 'like', "%{$v}%"))
            ->when($filtros['contrato'] ?? null, fn ($q, $v) => $q->where('tipoContrato', $v))
            ->when(($filtros['publica'] ?? null) === 'empresas', fn ($q) => $q->whereNotNull('idEmpresa'))
            ->when(($filtros['publica'] ?? null) === 'personas', fn ($q) => $q->whereNotNull('idUsuario'))
            ->when($filtros['categoria'] ?? null, function ($q, $idCategoria) {
                $q->whereIn('id', OfertaServicios::query()
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
        return OfertaServicios::with('servicio.categoria')
            ->whereIn('idOferta', $idsOfertas)
            ->get()
            ->groupBy('idOferta')
            ->map(fn ($filas) => optional($filas->first()->servicio?->categoria)->nombre)
            ->all();
    }

    public function listarCategorias()
    {
        return Categoria::orderBy('nombre')->get(['id', 'nombre']);
    }

    public function idsOfertasPostuladas(int $idUsuario): array
    {
        return Postulacion::where('idUsuario', $idUsuario)->pluck('idOferta')->all();
    }

    /** Devuelve ['Enviado' => n, 'Aceptado' => n, 'Rechazado' => n, 'Contratado' => n]. */
    public function contarPostulacionesPorEstado(int $idUsuario): array
    {
        return Postulacion::where('idUsuario', $idUsuario)
            ->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->all();
    }

    public function contarPostulantesPorRevisar(int $idUsuario): int
    {
        return Postulacion::where('estado', 'Enviado')
            ->whereHas('oferta', fn ($q) => $q->where('idUsuario', $idUsuario))
            ->count();
    }

    public function hojaDeVidaDe(int $idUsuario)
    {
        return HojaDeVida::where('idUsuario', $idUsuario)->latest('id')->first();
    }

    /** TEMPORAL: mientras no exista el login se usa el primer usuario registrado. */
    public function usuarioDePrueba()
    {
        return Usuario::first();
    }

    /** Devuelve [idOferta => ['id' => ..., 'estado' => ..., 'fecha' => 'dd/mm/aaaa']] de las postulaciones del usuario. */
    public function postulacionesPorOferta(int $idUsuario): array
    {
        return Postulacion::where('idUsuario', $idUsuario)->get()->mapWithKeys(fn ($p) => [$p->idOferta => [
                'id'     => $p->id,
                'estado' => $p->estado,
                'fecha'  => Carbon::parse($p->fecha)->format('d/m/Y'),
            ]])
            ->all();
    }

    public function eliminarServiciosPorOferta(int $id): void
    {
        OfertaServicios::where('idOferta', $id)->delete();
    }

    public function listarServicios()
    {
        return Servicios::orderBy('nombre')->get(['id', 'nombre', 'idCategoria']);
    }

    /** "Mis postulaciones" **/
    public function listarPostulacionesDeUsuario(int $idUsuario, array $filtros, int $porPagina)
    {
        $consulta = Postulacion::with(['oferta.empresa', 'oferta.usuario'])
            ->where('idUsuario', $idUsuario)
            ->when($filtros['estado'] ?? null, fn ($q, $estado) => $q->where('estado', $estado));

        match ($filtros['orden'] ?? 'recientes') {
            'antiguas' => $consulta->orderBy('fecha')->orderBy('id'),
            default    => $consulta->orderByDesc('fecha')->orderByDesc('id'),
        };

        return $consulta->paginate($porPagina)->withQueryString();
    }

    /** Devuelve [idPostulacion => puntuación] de lo que la persona ya calificó. */
    public function calificacionesPorPostulacion(array $idsPostulaciones, int $idUsuario): array
    {
        return Calificacion::whereIn('idPostulacion', $idsPostulaciones)
            ->where('idUsuario', $idUsuario)
            ->pluck('puntuacion', 'idPostulacion')
            ->all();
    }

    /** Aplica el filtro de estado a una consulta de ofertas (una sola regla para el listado y los contadores). */
    private function aplicarEstadoOferta($consulta, string $estado): void
    {
        $hoy = now('America/Bogota')->toDateString();
        $contratada = fn ($q) => $q->where('estado', 'Contratado');

        match ($estado) {
            'activas'      => $consulta->whereDate('fechaLimite', '>=', $hoy)->whereDoesntHave('postulaciones', $contratada),
            'contratacion' => $consulta->whereHas('postulaciones', $contratada),
            'vencidas'     => $consulta->whereDate('fechaLimite', '<', $hoy)->whereDoesntHave('postulaciones', $contratada),
            default        => null,
        };
    }

    /** Ofertas publicadas por la persona, filtradas por estado y ordenadas. */
    public function listarOfertasDeUsuario(int $idUsuario, array $filtros, int $porPagina)
    {
        $consulta = Oferta::where('idUsuario', $idUsuario);

        $this->aplicarEstadoOferta($consulta, $filtros['estado'] ?? 'todas');

        match ($filtros['orden'] ?? 'recientes') {
            'antiguas' => $consulta->orderBy('fechaPublicacion')->orderBy('id'),
            'vencen'   => $consulta->orderBy('fechaLimite')->orderBy('id'),
            default    => $consulta->orderByDesc('fechaPublicacion')->orderByDesc('id'),
        };

        return $consulta->paginate($porPagina)->withQueryString();
        }

    /** Devuelve ['todas' => n, 'activas' => n, 'contratacion' => n, 'vencidas' => n]. */
    public function contarOfertasPorEstado(int $idUsuario): array
    {
        $conteo = [];

        foreach (['todas', 'activas', 'contratacion', 'vencidas'] as $estado) {
            $consulta = Oferta::where('idUsuario', $idUsuario);
            $this->aplicarEstadoOferta($consulta, $estado);
            $conteo[$estado] = $consulta->count();
        }

        return $conteo;
    }

    /** Devuelve [idOferta => ['Enviado' => n, 'Aceptado' => n, ...]]. */
    public function contarPostulantesPorOferta(array $idsOfertas): array
    {
        return Postulacion::whereIn('idOferta', $idsOfertas)
            ->selectRaw('idOferta, estado, COUNT(*) as total')
            ->groupBy('idOferta', 'estado')
            ->get()
            ->groupBy('idOferta')
            ->map(fn ($filas) => $filas->pluck('total', 'estado')->all())
            ->all();
    }

    /** Devuelve [idOferta => nombre de la persona contratada]. */
    public function nombresContratadosPorOferta(array $idsOfertas): array
    {
        return Postulacion::with('usuario')
            ->whereIn('idOferta', $idsOfertas)
            ->where('estado', 'Contratado')
            ->get()
            ->mapWithKeys(fn ($p) => [
                $p->idOferta => $p->usuario ? trim($p->usuario->nombres . ' ' . $p->usuario->apellidos) : null,
            ])
            ->all();
    }

    /** Ofertas activas que vencen en los próximos $dias días. */
    public function contarOfertasQueVencenPronto(int $idUsuario, int $dias): int
    {
        $hoy = Carbon::now('America/Bogota');

        return Oferta::where('idUsuario', $idUsuario)
            ->whereDate('fechaLimite', '>=', $hoy->toDateString())
            ->whereDate('fechaLimite', '<=', $hoy->copy()->addDays($dias)->toDateString())
            ->whereDoesntHave('postulaciones', fn ($q) => $q->where('estado', 'Contratado'))
            ->count();
    }

    /** Ofertas activas a las que nadie se ha postulado. */
    public function contarOfertasSinPostulantes(int $idUsuario): int
    {
        return Oferta::where('idUsuario', $idUsuario)
            ->whereDate('fechaLimite', '>=', now('America/Bogota')->toDateString())
            ->doesntHave('postulaciones')
            ->count();
    }

    /** Contrataciones de la persona que ella todavía no ha calificado (subconsulta). */
    public function contarContratacionesPorCalificar(int $idUsuario): int
    {
        return Postulacion::where('estado', 'Contratado')
            ->whereHas('oferta', fn ($q) => $q->where('idUsuario', $idUsuario))
            ->whereNotIn('id', Calificacion::select('idPostulacion')
                ->where('tipoCalificador', '<>', 'usuario')
                ->whereNotNull('idPostulacion'))
            ->count();
    }

    /** Promedio y cantidad de calificaciones que la persona ha recibido. */
    public function reputacionDeUsuario(int $idUsuario): array
    {
        $fila = Calificacion::where('idUsuarioCalificado', $idUsuario)
            ->selectRaw('AVG(puntuacion) as promedio, COUNT(*) as total')
            ->first();

        return [
            'promedio' => (float) ($fila->promedio ?? 0),
            'total'    => (int) ($fila->total ?? 0),
        ];
    }

    public function tienePostulanteContratado(int $id): bool
    {
        return Postulacion::where('idOferta', $id)->where('estado', 'Contratado')->exists();
    }


    /** Busca una oferta del usuario que la publicó. */
    public function buscarOfertaDeUsuario(int $idOferta, int $idUsuario)
    {
        return Oferta::with(['ofertaServicio.servicio.categoria'])
            ->where('id', $idOferta)
            ->where('idUsuario', $idUsuario)
            ->firstOrFail();
    }

    /** Lista las postulaciones de una oferta con los datos de cada usuario y su hoja de vida. */
    public function listarPostulantesDeOferta(int $idOferta)
    {
        $postulaciones = Postulacion::with('usuario')->where('idOferta', $idOferta)->orderByDesc('fecha')->get();

        $hojasDeVida = HojaDeVida::whereIn('idUsuario', $postulaciones->pluck('idUsuario')->unique())->get()->keyBy('idUsuario');

        return $postulaciones->map(function ($postulacion) use ($hojasDeVida) {$postulacion->hojaDeVida = $hojasDeVida->get($postulacion->idUsuario);

        return $postulacion;
        });
    }

        /** Postulantes de una oferta: filtrados por estado, ordenados y paginados. */
    public function listarPostulantesPaginados(int $idOferta, array $filtros, int $porPagina)
    {
        $consulta = Postulacion::with('usuario')
            ->where('idOferta', $idOferta)
            ->when($filtros['estado'] ?? null, fn ($q, $estado) => $q->where('estado', $estado));

        match ($filtros['orden'] ?? 'recientes') {
            'antiguas' => $consulta->orderBy('fecha')->orderBy('id'),
            default    => $consulta->orderByDesc('fecha')->orderByDesc('id'),
        };

        return $consulta->paginate($porPagina)->withQueryString();
    }

    /** Devuelve [idUsuario => hoja de vida] de las personas indicadas (la más reciente de cada una). */
    public function hojasDeVidaPorUsuario(array $idsUsuarios): array
    {
        return HojaDeVida::whereIn('idUsuario', $idsUsuarios)
            ->orderBy('id')
            ->get()
            ->keyBy('idUsuario')
            ->all();
    }

}
