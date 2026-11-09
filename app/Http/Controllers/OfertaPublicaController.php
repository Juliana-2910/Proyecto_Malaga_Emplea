<?php

namespace App\Http\Controllers;

use App\Services\ofertasService;
use App\Services\postulacionService;
use App\Http\Requests\HojaDeVidaStoreRequest;
use App\Services\hojaDeVidaService;
use App\Http\Requests\OfertaStoreRequest;
use App\Services\calificacionService;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class OfertaPublicaController extends Controller
{
    private ofertasService $ofertasService;
    private postulacionService $postulacionService;
    private hojaDeVidaService $hojaDeVidaService;
    private calificacionService $calificacionService;

    public function __construct(ofertasService $ofertasService, postulacionService $postulacionService, hojaDeVidaService $hojaDeVidaService, calificacionService $calificacionService)
    {
        $this->ofertasService = $ofertasService;
        $this->postulacionService = $postulacionService;
        $this->hojaDeVidaService = $hojaDeVidaService;
        $this->calificacionService = $calificacionService;
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

            return view('Publico.usuarioPostulaciones', $datos);
        } catch (InvalidArgumentException $e) {
            // Solo filtros inválidos: se vuelve a la lista sin filtros.
            return redirect('/mis-postulaciones')->with('error', $e->getMessage());
        }
    }

    public function calificar(Request $request, int $id)
    {
        // Los errores van en su propio "bolsillo" para no abrir otros modales.
        $datos = $request->validateWithBag('calificar', [
            'idUsuario'  => 'required|exists:usuarios,id', // TEMPORAL: con el login sale de la sesión
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
        ], [
            'puntuacion.required' => 'Elige de 1 a 5 estrellas.',
            'puntuacion.min'      => 'Elige de 1 a 5 estrellas.',
            'puntuacion.max'      => 'Elige de 1 a 5 estrellas.',
            'comentario.required' => 'Cuéntanos cómo fue tu experiencia.',
            'comentario.max'      => 'El comentario no puede superar los 500 caracteres.',
        ]);

        try {
            $this->calificacionService->calificarContratacion(
                $id,
                (int) $datos['idUsuario'],
                (int) $datos['puntuacion'],
                $datos['comentario']
            );
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Tu calificación se envió correctamente.');
    }
}
