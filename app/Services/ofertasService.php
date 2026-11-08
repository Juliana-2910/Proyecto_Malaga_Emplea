<?php

namespace App\Services;

use App\Repositories\ofertasRepository;
use App\Repositories\ofertaServiciosRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use InvalidArgumentException;
use Exception;

class ofertasService
{
    private ofertasRepository $ofertasrepository;
    private ofertaServiciosRepository $ofertaServiciosRepository;

    public function __construct(ofertasRepository $ofertasrepository, ofertaServiciosRepository $ofertaServiciosRepository)
    {
        $this->ofertasrepository = $ofertasrepository;
        $this->ofertaServiciosRepository = $ofertaServiciosRepository;
    }

    public function listarTodos()
    {
        return $this->ofertasrepository->listarTodos();
    }

    public function listarDisponiblesParaPostular()
    {
        return $this->ofertasrepository->listarDisponiblesParaPostular();
    }

    public function guardar(array $datos)
    {
        return DB::transaction(function () use ($datos) {

            $idServicio = $datos['idServicio'];
            unset($datos['idCategoria'], $datos['idServicio']);
            $datos['fechaPublicacion'] = Carbon::now('America/Bogota')->toDateString();
            $this->validarSalarioMinimo($datos);
            $oferta = $this->ofertasrepository->guardar($datos);
            $this->ofertaServiciosRepository->guardar(['idOferta' => $oferta->id, 'idServicio' => $idServicio,]);
            return $oferta;
        });
    }

    public function eliminar(int $id)
    {
        return DB::transaction(function () use ($id) {

            // Verificar si la oferta tiene postulaciones.
            if ($this->ofertasrepository->tienePostulaciones($id)) {
                throw new Exception('No se puede eliminar esta oferta porque tiene postulaciones relacionadas.');
            }

            // Eliminar las relaciones con los servicios.
            $this->ofertasrepository->eliminarServiciosPorOferta($id);

            // Eliminar la oferta.
            $this->ofertasrepository->eliminar($id);
        });
    }

    public function buscarporid(int $id)
    {
        return $this->ofertasrepository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos)
    {
        return DB::transaction(function () use ($id, $datos) {

            $idServicio = $datos['idServicio'];
            unset($datos['idCategoria'], $datos['idServicio'], $datos['fechaPublicacion']);
            $this->validarSalarioMinimo($datos);
            $this->ofertasrepository->actualizar($id, $datos);
            $this->ofertaServiciosRepository->actualizarPorOferta($id,$idServicio);
        });
    }

    private function validarSalarioMinimo(array $datos): void
    {
        if (
            isset($datos['salario']) &&
            is_numeric($datos['salario']) &&
            $datos['salario'] < 5000
        ) {
            throw new Exception(
                'El salario ofrecido debe ser igual o superior a $5000 COP.'
            );
        }
    }

    public function listarOfertasSobrePromedioPostulaciones()
    {
        return $this->ofertasrepository->listarOfertasSobrePromedioPostulaciones();
    }

    public function listarOfertasConServicios()
    {
        return $this->ofertasrepository->listarOfertasConServicios();
    }

    public function listarOfertasSinServicios()
    {
        return $this->ofertasrepository->listarOfertasSinServicios();
    }

/* ===== Vista "Ofertas con sesión" (usuario) ===== */

    private const CONTRATOS = ['tiempo completo', 'medio tiempo', 'horas', 'porcentaje'];
    private const PUBLICA = ['empresas', 'personas'];
    private const ORDENES = ['recientes', 'antiguas', 'vencen'];
    private const POR_PAGINA = 10;
    private const ESTADOS_POSTULACION = ['Enviado', 'Aceptado', 'Rechazado','Contratado'];
    private const ORDENES_POSTULACION = ['recientes', 'antiguas'];

    public function datosListadoUsuario(array $filtros): array
    {
        $this->validarFiltros($filtros);

        // TEMPORAL: cuando exista el login, el usuario sale de auth().
        $usuario = $this->ofertasrepository->usuarioDePrueba();
        $idUsuario = $usuario?->id;

        $ofertas = $this->ofertasrepository->listarActivas($filtros, self::POR_PAGINA);

        $categoriasPorOferta = $this->ofertasrepository->categoriasPorOferta($ofertas->pluck('id')->all());
        $postulaciones = $idUsuario ? $this->ofertasrepository->postulacionesPorOferta($idUsuario) : [];

        $ofertas->through(function ($oferta) use ($categoriasPorOferta, $postulaciones) {
            $oferta->publicador = $this->nombrePublicador($oferta);
            $oferta->categoria = $categoriasPorOferta[$oferta->id] ?? null;
            $oferta->postulacion = $postulaciones[$oferta->id] ?? null;
            $oferta->postulado = $oferta->postulacion !== null;
            return $oferta;
        });

        $porEstado = $idUsuario ? $this->ofertasrepository->contarPostulacionesPorEstado($idUsuario) : [];

        return [
            'nombre'                => $usuario?->nombres ?? 'Usuario',
            'esEmpresa'             => false, // TEMPORAL: se define con el login
            'idUsuario'             => $idUsuario, // TEMPORAL: con el login sale de la sesión
            'totalOfertas'          => $ofertas->total(),
            'ofertas'               => $ofertas,
            'categorias'            => $this->ofertasrepository->listarCategorias(),
            'servicios'             => $this->ofertasrepository->listarServicios(),
            'resumenPostulaciones'  => [
                'enviadas'   => $porEstado['Enviado'] ?? 0,
                'aceptadas'  => $porEstado['Aceptado'] ?? 0,
                'rechazadas' => $porEstado['Rechazado'] ?? 0,
                'contratadas' => $porEstado['Contratado'] ?? 0,
            ],
            'postulantesPorRevisar' => $idUsuario ? $this->ofertasrepository->contarPostulantesPorRevisar($idUsuario) : 0,
            'hojaDeVidaProgreso'    => $idUsuario ? $this->progresoHojaDeVida($idUsuario) : 0,
            'hojaDeVida' => $this->ofertasrepository->hojaDeVidaDe($idUsuario),
            ];
    }

    private function validarFiltros(array $filtros): void
    {
        if (! empty($filtros['contrato']) && ! in_array($filtros['contrato'], self::CONTRATOS, true)) {
            throw new InvalidArgumentException('El tipo de contrato seleccionado no es válido.');
        }

        if (! empty($filtros['publica']) && ! in_array($filtros['publica'], self::PUBLICA, true)) {
            throw new InvalidArgumentException('La opción "Publicada por" no es válida.');
        }

        if (! empty($filtros['orden']) && ! in_array($filtros['orden'], self::ORDENES, true)) {
            throw new InvalidArgumentException('El orden seleccionado no es válido.');
        }

        if (! empty($filtros['categoria']) && ! ctype_digit((string) $filtros['categoria'])) {
            throw new InvalidArgumentException('La categoría seleccionada no es válida.');
        }
    }

    private function nombrePublicador($oferta): string
    {
        if ($oferta->empresa) {
            return $oferta->empresa->nombreEmpresa;
        }

        if ($oferta->usuario) {
            return trim($oferta->usuario->nombres . ' ' . $oferta->usuario->apellidos);
        }

        return 'Publicador no disponible';
    }

    /** Porcentaje de campos de la hoja de vida que ya están llenos. */
    private function progresoHojaDeVida(int $idUsuario): int
    {
        $hoja = $this->ofertasrepository->hojaDeVidaDe($idUsuario);

        if (! $hoja) {
            return 0;
        }

        $campos = ['ubicacion', 'nivelEducativo', 'perfilProfesional', 'experienciaLaboral', 'archivoCV'];
        $llenos = collect($campos)->filter(fn ($campo) => filled($hoja->{$campo}))->count();

        return (int) round($llenos / count($campos) * 100);
    }

    /** "Mis postulaciones" **/

    public function datosMisPostulaciones(array $filtros): array
    {
        $this->validarFiltrosPostulaciones($filtros);

        // TEMPORAL: cuando exista el login, el usuario sale de auth().
        $usuario = $this->ofertasrepository->usuarioDePrueba();
        $idUsuario = $usuario?->id;

        $postulaciones = $this->ofertasrepository->listarPostulacionesDeUsuario($idUsuario ?? 0, $filtros, self::POR_PAGINA);

        $categorias = $this->ofertasrepository->categoriasPorOferta($postulaciones->pluck('idOferta')->all());

        $postulaciones->through(function ($postulacion) use ($categorias) {
            $postulacion->oferta->publicador = $this->nombrePublicador($postulacion->oferta);
            $postulacion->oferta->categoria = $categorias[$postulacion->idOferta] ?? null;
            return $postulacion;
        });

        $porEstado = $idUsuario ? $this->ofertasrepository->contarPostulacionesPorEstado($idUsuario) : [];

        return [
            'nombre'         => $usuario?->nombres ?? 'Usuario',
            'idUsuario'      => $idUsuario, // TEMPORAL: con el login sale de la sesión
            'postulaciones'  => $postulaciones,
            'conteos'        => [
                'todas'      => array_sum($porEstado),
                'Enviado'    => $porEstado['Enviado'] ?? 0,
                'Aceptado'   => $porEstado['Aceptado'] ?? 0,
                'Rechazado'  => $porEstado['Rechazado'] ?? 0,
                'Contratado' => $porEstado['Contratado'] ?? 0
            ],
        ];
    }

    private function validarFiltrosPostulaciones(array $filtros): void
    {
        if (! empty($filtros['estado']) && ! in_array($filtros['estado'], self::ESTADOS_POSTULACION, true)) {
            throw new InvalidArgumentException('El estado seleccionado no es válido.');
        }

        if (! empty($filtros['orden']) && ! in_array($filtros['orden'], self::ORDENES_POSTULACION, true)) {
            throw new InvalidArgumentException('El orden seleccionado no es válido.');
        }
    }
}
