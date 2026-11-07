<?php

namespace App\Http\Controllers;

use App\Services\ofertasService;
use App\Services\postulacionService;
use App\Http\Requests\HojaDeVidaStoreRequest;
use App\Services\hojaDeVidaService;
use App\Http\Requests\OfertaStoreRequest;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class OfertaPublicaController extends Controller
{
    private ofertasService $ofertasService;
    private postulacionService $postulacionService;
    private hojaDeVidaService $hojaDeVidaService;

    public function __construct(ofertasService $ofertasService, postulacionService $postulacionService, hojaDeVidaService $hojaDeVidaService)
    {
        $this->ofertasService = $ofertasService;
        $this->postulacionService = $postulacionService;
        $this->hojaDeVidaService = $hojaDeVidaService;
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

    public function cancelarPostulacion(Request $request, int $id)
    {
        // TEMPORAL: con el login, el idUsuario sale de la sesión y no del formulario.
        $request->validate(['idUsuario' => 'required|exists:usuarios,id']);

        try {
            $this->postulacionService->cancelar($id, (int) $request->input('idUsuario'));

            return back()->with('eliminar', 'Tu postulación fue cancelada correctamente.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function guardarHojaDeVida(HojaDeVidaStoreRequest $request)
    {
        $datos = $request->validated();
        $datos['fechaActualizacion'] = now('America/Bogota');

        try {
            $this->hojaDeVidaService->guardarOActualizar($datos);
        } catch (\Exception $e) {
            return redirect()->route('Publico.ofertas')->with('error', $e->getMessage());
        }
        return redirect()->route('Publico.ofertas')->with('success', 'Tu hoja de vida se guardó correctamente.');
    }

    public function guardarOferta(OfertaStoreRequest $request) // Es un modal creado aparte //
    {
        try { // Se reutiliza ofertasService::guardar (pone la fecha de publicación, valida el salario mínimo y llena la tabla intermedia ofertaServicios) //
            $this->ofertasService->guardar($request->validated());
        } catch (Exception $e) {
            return redirect()->route('Publico.ofertas')->withInput()->with('errorModal', $e->getMessage())->with('abrirCrearOferta', true);
        }
        return redirect()->route('Publico.ofertas')->with('success', 'Tu oferta se publicó correctamente.');
    }

    public function misPostulaciones(Request $request)
    {
        try {
            $datos = $this->ofertasService->datosMisPostulaciones(
                $request->only(['estado', 'orden'])
            );

            return view('Publico.postulaciones', $datos);
        } catch (InvalidArgumentException $e) {
            // Solo filtros inválidos: se vuelve a la lista sin filtros.
            return redirect('/mis-postulaciones')->with('error', $e->getMessage());
        }
    }
}
