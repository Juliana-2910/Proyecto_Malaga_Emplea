<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class dashboardRepository
{
    // MUESTRA EL DASHBOARD PRINCIPAL DE MALAGA EMPLEA //
    public function obtenerIndicadores()
    {
        return [
            // Total de usuarios registrados //
            'totalUsers' => DB::table('usuarios')->count(),

            // Total de empresas registradas //
            'totalCompanies' => DB::table('empresas')->count(),

            // Total de ofertas registradas //
            'totalOffers' => DB::table('ofertas')->count(),

            // Total de servicios publicados //
            'totalServices' => DB::table('servicios')->count(),

            // INFORMACION GENERAL DE LA PLATAFORMA //

            // Usuarios activos //
            'activeUsers' => DB::table('usuarios')
                ->where('estado', 'Activo')
                ->count(),

            // Empresas activas //
            'activeCompanies' => DB::table('empresas')
                ->where('estado', 'activo')
                ->count(),

            // Total hojas de vida //
            'totalCV' => DB::table('hojaDeVida')->count(),

            // Total de categorias //
            'totalCategories' => DB::table('categorias')->count(),
        ];
    }

    // Obtiene las cantidades de postulaciones por estado//

    public function obtenerEstadisticasPostulaciones()
    {
        return [
            'postulacionesEnviadas' => DB::table('postulacion')
                ->where('estado', 'Enviado')
                ->count(),

            'postulacionesAceptadas' => DB::table('postulacion')
                ->where('estado', 'Aceptado')
                ->count(),

            'postulacionesRechazadas' => DB::table('postulacion')
                ->where('estado', 'Rechazado')
                ->count(),
        ];
    }

    // Obtiene las últimas cinco ofertas laborales //

    public function obtenerOfertasRecientes()
    {
        return DB::table('ofertas')
            ->join(
                'empresas',
                'ofertas.idEmpresa',
                '=',
                'empresas.id'
            )
            ->select(
                'ofertas.id',
                'ofertas.titulo',
                'ofertas.created_at',
                'empresas.nombreEmpresa'
            )
            ->orderByDesc('ofertas.created_at')
            ->limit(5)
            ->get();
    }

    // Obtiene los últimos cinco servicios publicados //

    public function obtenerServiciosRecientes()
    {
        return DB::table('servicios')
            ->join(
                'categorias',
                'servicios.idCategoria',
                '=',
                'categorias.id'
            )
            ->select(
                'servicios.id',
                'servicios.nombre',
                'servicios.created_at',
                'categorias.nombre as categoria'
            )
            ->orderByDesc('servicios.created_at')
            ->limit(5)
            ->get();
    }

    // Obtiene las últimas cinco postulaciones //
    public function obtenerPostulacionesRecientes()
    {
        return DB::table('postulacion')
            ->join(
                'usuarios',
                'postulacion.idUsuario',
                '=',
                'usuarios.id'
            )
            ->join(
                'ofertas',
                'postulacion.idOferta',
                '=',
                'ofertas.id'
            )
            ->select(
                'postulacion.id',
                'postulacion.fecha',
                'postulacion.created_at',
                'postulacion.estado',
                'usuarios.nombres',
                'usuarios.apellidos',
                'ofertas.titulo'
            )
            ->orderByDesc('postulacion.fecha')
            ->limit(5)
            ->get();
    }
}
