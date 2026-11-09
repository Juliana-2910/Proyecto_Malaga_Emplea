<?php

namespace App\Http\Controllers;

use App\Services\ofertasService;
use App\Services\postulacionService;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class OfertaPublicaController extends Controller
{
    private ofertasService $ofertasService;
    private postulacionService $postulacionService;

    public function __construct(ofertasService $ofertasService, postulacionService $postulacionService)
    {
        $this->ofertasService = $ofertasService;
        $this->postulacionService = $postulacionService;
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

        public function postular(int $id)
    {
    // Solo los usuarios pueden postularse.
    $usuario = auth('web')->user();

    if (!$usuario) {
        return redirect('/empleos')
            ->with('error', 'Debes ingresar como usuario para postularte.');
    }

    try {
        $this->postulacionService->guardar([
            'idUsuario' => $usuario->id,
            'idOferta'  => $id,
        ]);

        return redirect('/empleos')
            ->with('success', 'Te postulaste correctamente a la oferta.');

    } catch (Exception $e) {
        return redirect('/empleos')
            ->with('error', $e->getMessage());
    }
    }
}