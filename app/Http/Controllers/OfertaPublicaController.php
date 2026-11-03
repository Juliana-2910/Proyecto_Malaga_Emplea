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

        public function postular(Request $request, int $id)
    {
        // TEMPORAL: con el login, el idUsuario sale de la sesión y no del formulario.
        $request->validate(['idUsuario' => 'required|exists:usuarios,id']);

        try {
            // Se reutiliza el service de postulaciones del panel (ya trae todas las reglas).
            $this->postulacionService->guardar([
                'idUsuario' => $request->input('idUsuario'),
                'idOferta'  => $id,
            ]);

            return redirect('/empleos')->with('success', 'Te postulaste correctamente a la oferta.');
        } catch (Exception $e) {
            return redirect('/empleos')->with('error', $e->getMessage());
        }
    }
}
