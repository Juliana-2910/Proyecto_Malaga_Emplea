<?php

namespace App\Http\Controllers;

use App\Services\ofertasService;
use App\Services\postulacionService;
use App\Http\Requests\HojaDeVidaStoreRequest;
use App\Services\hojaDeVidaService;
use App\Http\Requests\OfertaStoreRequest;
use App\Http\Requests\OfertaUpdateRequest;
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
                $request->only(['q', 'categoria', 'contrato', 'publica', 'orden']),
                $request->user()
            );

            return view('Publico.UsuarioOfertas', $datos);
        } catch (InvalidArgumentException $e) {
            // Solo errores de filtros inválidos: se vuelve al listado sin filtros.
            return redirect('/empleos')->with('error', $e->getMessage());
        }
    }

        public function postular(int $id)
    {
    // Solo las cuentas personales pueden postularse.
    $usuario = request()->user();

    if (!$usuario instanceof \App\Models\Usuario) {
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
        // El propietario se obtiene de la sesión autenticada, no del formulario.
        $usuario = $request->user();
        abort_unless($usuario instanceof \App\Models\Usuario, 403, 'Solo los usuarios pueden cancelar postulaciones.');

        try {
            $this->postulacionService->cancelar($id, (int) $usuario->id);

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
            $datos = $request->validated();
            unset($datos['idUsuario'], $datos['idEmpresa']);

            if (($cuenta = $request->user()) instanceof \App\Models\Empresa) {
                $empresa = $cuenta;
                $datos['idEmpresa'] = $empresa->id;
            } else {
                $usuario = $cuenta;
                abort_unless($usuario, 403);
                $datos['idUsuario'] = $usuario->id;
            }

            $this->ofertasService->guardar($datos);
        } catch (Exception $e) {
            return redirect()->route('Publico.ofertas')->withInput()->with('errorModal', $e->getMessage())->with('abrirCrearOferta', true);
        }
        return redirect()->route('Publico.ofertas')->with('success', 'Tu oferta se publicó correctamente.');
    }

    public function actualizarOferta(OfertaUpdateRequest $request, int $id)
    {
        try {
            $cuenta = $request->user();
            abort_unless($cuenta, 403);
            $this->ofertasService->actualizarMiOferta($id, $request->validated(), $cuenta);
        } catch (Exception $e) {
            return redirect()->route('Publico.misOfertas')->withInput()->with('errorModal', $e->getMessage())->with('abrirEditarOferta', $id);
        }

        return redirect()->route('Publico.misOfertas')->with('actualizar', 'Tu oferta se actualizó correctamente.');
    }

    public function misPostulaciones(Request $request)
    {
        $usuario = $request->user();
        if (! $usuario instanceof \App\Models\Usuario) {
            return redirect()->route('Publico.ofertas')->with('error', 'Mis postulaciones está disponible para cuentas de usuario.');
        }

        try {
            $datos = $this->ofertasService->datosMisPostulaciones(
                $request->only(['estado', 'orden']),
                $usuario
            );

            return view('Publico.usuarioPostulaciones', $datos);
        } catch (InvalidArgumentException $e) {
            // Solo filtros inválidos: se vuelve a la lista sin filtros.
            return redirect('/mis-postulaciones')->with('error', $e->getMessage());
        }
    }

    public function calificar(Request $request, int $id)
    {
        $usuario = $request->user();
        abort_unless($usuario instanceof \App\Models\Usuario, 403, 'Solo los usuarios pueden enviar esta calificación.');

        // Los errores van en su propio "bolsillo" para no abrir otros modales.
        $datos = $request->validateWithBag('calificar', [
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:255',
        ], [
            'puntuacion.required' => 'Elige de 1 a 5 estrellas.',
            'puntuacion.min'      => 'Elige de 1 a 5 estrellas.',
            'puntuacion.max'      => 'Elige de 1 a 5 estrellas.',
            'comentario.required' => 'Cuéntanos cómo fue tu experiencia.',
            'comentario.max'      => 'El comentario no puede superar los 255 caracteres.',
        ]);

        try {
            $this->calificacionService->calificarContratacion(
                $id,
                (int) $usuario->id,
                (int) $datos['puntuacion'],
                $datos['comentario']
            );
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Tu calificación se envió correctamente.');
    }

    public function misOfertas(Request $request)
    {
        try {
            $cuenta = $request->user();
            abort_unless($cuenta, 403);
            $datos = $this->ofertasService->datosMisOfertas(
                $request->only(['estado', 'orden']),
                $cuenta
            );

            return view('Publico.misOfertas', $datos);
        } catch (InvalidArgumentException $e) {
            return redirect('/mis-ofertas')->with('error', $e->getMessage());
        }
    }

    public function actualizarEstadoPostulante(Request $request, int $id)
    {
        $datos = $request->validate([
            'estado' => ['required', 'in:Aceptado,Rechazado,Contratado'],
        ]);
        $publicador = $request->user();
        abort_unless($publicador, 403);

        try {
            $this->postulacionService->cambiarEstadoDesdePanel($id, $datos['estado'], $publicador);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', match ($datos['estado']) {
            'Aceptado' => 'La postulación fue aceptada.',
            'Rechazado' => 'La postulación fue rechazada.',
            default => 'La persona fue contratada. Ya puedes calificar el servicio.',
        });
    }

    public function calificarPostulante(Request $request, int $id)
    {
        $publicador = $request->user();
        abort_unless($publicador, 403);

        $datos = $request->validateWithBag('calificar', [
            'puntuacion' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['required', 'string', 'max:255'],
        ], [
            'puntuacion.required' => 'Elige de 1 a 5 estrellas.',
            'puntuacion.min' => 'Elige de 1 a 5 estrellas.',
            'puntuacion.max' => 'Elige de 1 a 5 estrellas.',
            'comentario.required' => 'Cuéntanos cómo fue la experiencia.',
            'comentario.max' => 'El comentario no puede superar los 255 caracteres.',
        ]);

        try {
            $this->calificacionService->calificarPostulante(
                $id,
                $publicador,
                (int) $datos['puntuacion'],
                $datos['comentario']
            );
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'La calificación se envió correctamente.');
    }

        public function postulantes(Request $request, int $id)
    {
        try {
            $cuenta = $request->user();
            abort_unless($cuenta, 403);
            $datos = $this->ofertasService->datosPostulantes(
                $id,
                $request->only(['estado', 'orden']),
                $cuenta
            );

            return view('Publico.postulantes', $datos);
        } catch (InvalidArgumentException $e) {
            // Filtro inválido: se vuelve a la lista de esa oferta sin filtros.
            return redirect()->route('Publico.misOfertas.postulantes', $id)->with('error', $e->getMessage());
        } catch (Exception $e) {
            // Oferta que no existe o que no es tuya.
            return redirect()->route('Publico.misOfertas')->with('error', $e->getMessage());
        }
    }
}
