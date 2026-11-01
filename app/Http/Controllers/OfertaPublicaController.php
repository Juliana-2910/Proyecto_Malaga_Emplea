<?php

namespace App\Http\Controllers;

use App\Services\ofertasService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class OfertaPublicaController extends Controller
{
    private ofertasService $ofertasService;

    public function __construct(ofertasService $ofertasService)
    {
        $this->ofertasService = $ofertasService;
    }

    public function index(Request $request)
    {
        try {
            $datos = $this->ofertasService->datosListadoUsuario(
                $request->only(['q', 'categoria', 'contrato', 'publica', 'orden'])
            );

            return view('Publico.UsuarioOfertas', $datos);
        } catch (InvalidArgumentException $e) {
            // Solo errores de filtros inválidos: se vuelve al listado sin filtros.
            return redirect('/empleos')->with('error', $e->getMessage());
        }
    }
}
