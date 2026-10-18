<?php

namespace App\Services;

use App\Repositories\dashboardRepository;
use Carbon\Carbon;

class dashboardService
{
    protected dashboardRepository $dashboardRepository;

    public function __construct(dashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    // Prepara toda la información del dashboard //
    public function obtenerDatosDashboard(): array
    {
        // Indicadores principales e información general //
        $indicadores = $this->dashboardRepository->obtenerIndicadores();

        // Estadísticas de postulaciones //
        $estadisticas = $this->dashboardRepository
            ->obtenerEstadisticasPostulaciones();

        $postulacionesEnviadas = $estadisticas['postulacionesEnviadas'];
        $postulacionesAceptadas = $estadisticas['postulacionesAceptadas'];
        $postulacionesRechazadas = $estadisticas['postulacionesRechazadas'];

        // Total de postulaciones //
        $totalPostulaciones =
            $postulacionesEnviadas +
            $postulacionesAceptadas +
            $postulacionesRechazadas;

        // Porcentajes de postulaciones //
        $porcentajeEnviadas = 0;
        $porcentajeAceptadas = 0;
        $porcentajeRechazadas = 0;

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
        }

        // Información reciente //
        $recentOffers = $this->dashboardRepository
            ->obtenerOfertasRecientes();

        $recentServices = $this->dashboardRepository
            ->obtenerServiciosRecientes();

        $recentApplications = $this->dashboardRepository
            ->obtenerPostulacionesRecientes();

        // Preparar la actividad reciente //
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

                'time' => $application->created_at
                    ? Carbon::parse($application->created_at)->locale('es')->diffForHumans()
                    : '',
            ];
        }

        // Entregar todos los datos que necesita la vista //
        return array_merge(
            $indicadores,
            $estadisticas,
            [
                'totalPostulaciones' => $totalPostulaciones,

                'porcentajeEnviadas' => $porcentajeEnviadas,
                'porcentajeAceptadas' => $porcentajeAceptadas,
                'porcentajeRechazadas' => $porcentajeRechazadas,

                'recentOffers' => $recentOffers,
                'recentServices' => $recentServices,
                'recentActivity' => $recentActivity,
            ]
        );
    }
}
