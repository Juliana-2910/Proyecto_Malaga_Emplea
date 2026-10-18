<?php

namespace App\Http\Controllers;

use App\Services\dashboardService;

class DashboardController extends Controller
{
    protected dashboardService $dashboardService;

    public function __construct(dashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    // Muestra el dashboard principal de Málaga Emplea //

    public function index()
    {
        $datosDashboard = $this->dashboardService
            ->obtenerDatosDashboard();

        return view('dashboard.index', $datosDashboard);
    }
}
