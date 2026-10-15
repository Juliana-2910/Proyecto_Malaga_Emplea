<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /** Muestra el dashboard principal de Málaga Emplea. */
    public function index(Request $request)
    {
        /*  INDICADORES PRINCIPALES */

        // Total de usuarios registrados
        $totalUsers = DB::table('usuarios')->count();

        // Total de empresas registradas
        $totalCompanies = DB::table('empresas')->count();

        // Total de ofertas laborales
        $totalOffers = DB::table('ofertas')->count();

        // Total de servicios publicados
        $totalServices = DB::table('servicios')->count();


        /* INFORMACIÓN GENERAL DE LA PLATAFORMA */

        // Usuarios activos
        $activeUsers = DB::table('usuarios')
            ->where('estado', 'Activo')
            ->count();

        // Empresas activas
        $activeCompanies = DB::table('empresas')
            ->where('estado', 'activo')
            ->count();

        // Total de hojas de vida
        $totalCV = DB::table('hojaDeVida')->count();

        // Total de categorias
        $totalCategories = DB::table('categorias')->count();


        /* POSTULACIONES */

        // Postulaciones enviadas
        $postulacionesEnviadas = DB::table('postulacion')
            ->where('estado', 'Enviado')
            ->count();

        // Postulaciones aceptadas
        $postulacionesAceptadas = DB::table('postulacion')
            ->where('estado', 'Aceptado')
            ->count();

        // Postulaciones rechazadas
        $postulacionesRechazadas = DB::table('postulacion')
            ->where('estado', 'Rechazado')
            ->count();


        // Total de postulaciones
        $totalPostulaciones =
            $postulacionesEnviadas +
            $postulacionesAceptadas +
            $postulacionesRechazadas;


        /* PORCENTAJES DE POSTULACIONES */

        if ($totalPostulaciones > 0) {

            $porcentajeEnviadas = round(
                ($postulacionesEnviadas / $totalPostulaciones) * 100
            );

            $porcentajeAceptadas = round(
                ($postulacionesAceptadas / $totalPostulaciones) * 100
            );

            $porcentajeRechazadas = round(
                ($postulacionesRechazadas / $totalPostulaciones) * 100
            );

        } else {

            $porcentajeEnviadas = 0;
            $porcentajeAceptadas = 0;
            $porcentajeRechazadas = 0;
        }


        /* ÚLTIMAS OFERTAS LABORALES */

        $recentOffers = DB::table('ofertas')
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


        /* SERVICIOS RECIENTES */

        $recentServices = DB::table('servicios')
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


        /* ACTIVIDAD RECIENTE */

        $recentApplications = DB::table('postulacion')
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
                'postulacion.estado',
                'usuarios.nombres',
                'usuarios.apellidos',
                'ofertas.titulo'
            )
            ->orderByDesc('postulacion.fecha')
            ->limit(5)
            ->get();


        /* PREPARAR ACTIVIDAD PARA EL DASHBOARD */

        $recentActivity = [];

        foreach ($recentApplications as $application) {

            $nombreUsuario = trim(
                ($application->nombres ?? '') .
                ' ' .
                ($application->apellidos ?? '')
            );

            $recentActivity[] = [
                'name' => $nombreUsuario ?: 'Usuario',

                'action' => 'realizó una postulación para "' .
                    ($application->titulo ?? 'Oferta laboral') .
                    '"',

                'time' => $application->fecha
                    ? Carbon::parse($application->fecha, 'America/Bogota')->locale('es')->diffForHumans()
                    : '',
            ];
        }


        /* ENVIAR INFORMACIÓN A LA VISTA */

        return view('dashboard.index', compact(

            // Indicadores principales
            'totalUsers',
            'totalCompanies',
            'totalOffers',
            'totalServices',

            // Información general
            'activeUsers',
            'activeCompanies',
            'totalCV',
            'totalCategories',
            
            // Postulaciones
            'postulacionesEnviadas',
            'postulacionesAceptadas',
            'postulacionesRechazadas',
            'totalPostulaciones',

            // Porcentajes
            'porcentajeEnviadas',
            'porcentajeAceptadas',
            'porcentajeRechazadas',

            // Información reciente
            'recentOffers',
            'recentServices',
            'recentActivity'
        ));
    }
}
