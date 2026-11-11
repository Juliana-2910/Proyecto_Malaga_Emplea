<?php

namespace App\Services;

use App\Repositories\ofertasRepository;
use App\Repositories\ofertaServiciosRepository;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    private const ESTADOS_OFERTA = ['todas', 'activas', 'contratacion', 'vencidas'];
    private const DIAS_VENCE_PRONTO = 3;

    public function datosListadoUsuario(array $filtros, Usuario|Empresa $cuenta): array
    {
        $this->validarFiltros($filtros);

        $esEmpresa = $cuenta instanceof Empresa;
        $idUsuario = $esEmpresa ? null : $cuenta->id;

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
            'nombre'                => $esEmpresa ? $cuenta->nombreEmpresa : trim($cuenta->nombres . ' ' . $cuenta->apellidos),
            'esEmpresa'             => $esEmpresa,
            'idUsuario'             => $idUsuario,
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
            'postulantesPorRevisar' => $this->ofertasrepository->contarPostulantesPorRevisarDePublicador($cuenta->id, $esEmpresa),
            'hojaDeVidaProgreso'    => $idUsuario ? $this->progresoHojaDeVida($idUsuario) : 0,
            'hojaDeVida' => $idUsuario ? $this->ofertasrepository->hojaDeVidaDe($idUsuario) : null,
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

    public function datosMisPostulaciones(array $filtros, Usuario $usuario): array
    {
        $this->validarFiltrosPostulaciones($filtros);

        $idUsuario = $usuario->id;

        $postulaciones = $this->ofertasrepository->listarPostulacionesDeUsuario($idUsuario ?? 0, $filtros, self::POR_PAGINA);

        $categorias = $this->ofertasrepository->categoriasPorOferta($postulaciones->pluck('idOferta')->all());
        $calificaciones = $this->ofertasrepository->calificacionesPorPostulacion($postulaciones->pluck('id')->all(), $idUsuario ?? 0);

        $postulaciones->through(function ($postulacion) use ($categorias, $calificaciones) {
            $postulacion->oferta->publicador = $this->nombrePublicador($postulacion->oferta);
            $postulacion->oferta->categoria = $categorias[$postulacion->idOferta] ?? null;
            $postulacion->calificacion = $calificaciones[$postulacion->id] ?? null; // puntuación, o null si aún no calificas
            return $postulacion;
        });

        $porEstado = $idUsuario ? $this->ofertasrepository->contarPostulacionesPorEstado($idUsuario) : [];

        return [
            'nombre'         => trim($usuario->nombres . ' ' . $usuario->apellidos),
            'idUsuario'      => $idUsuario,
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

    public function datosMisOfertas(array $filtros, Usuario|Empresa $cuenta): array
    {
        $this->validarFiltrosMisOfertas($filtros);

        $esEmpresa = $cuenta instanceof Empresa;
        $idPublicador = $cuenta->id;
        $usuario = $esEmpresa ? null : $cuenta;

        $ofertas = $this->ofertasrepository->listarOfertasDePublicador($idPublicador, $esEmpresa, $filtros, self::POR_PAGINA);

        $ids = $ofertas->pluck('id')->all();
        $categorias = $this->ofertasrepository->categoriasPorOferta($ids);
        $postulantes = $this->ofertasrepository->contarPostulantesPorOferta($ids);
        $contratados = $this->ofertasrepository->nombresContratadosPorOferta($ids);

        $ofertas->through(function ($oferta) use ($categorias, $postulantes, $contratados) {
            $porEstado = $postulantes[$oferta->id] ?? [];
            $contratadas = $porEstado['Contratado'] ?? 0;

            $oferta->categoria = $categorias[$oferta->id] ?? null;
            $oferta->resumenPostulantes = [
                'enviadas'    => $porEstado['Enviado'] ?? 0,
                'aceptadas'   => $porEstado['Aceptado'] ?? 0,
                'rechazadas'  => $porEstado['Rechazado'] ?? 0,
                'contratadas' => $contratadas,
            ];
            $oferta->nombreContratado = $contratados[$oferta->id] ?? null;
            $oferta->estadoOferta = $this->estadoDeOferta($contratadas, $oferta->fechaLimite);

            return $oferta;
        });

        return [
            'nombre'        => $esEmpresa ? $cuenta->nombreEmpresa : trim($cuenta->nombres . ' ' . $cuenta->apellidos),
            'idUsuario'     => $usuario?->id,
            'idEmpresa'     => $esEmpresa ? $cuenta->id : null,
            'esEmpresa'     => $esEmpresa,
            'ofertas'       => $ofertas,
            'categorias'    => $this->ofertasrepository->listarCategorias(),
            'servicios'     => $this->ofertasrepository->listarServicios(),
            'conteoEstados' => $this->ofertasrepository->contarOfertasPorPublicador($idPublicador, $esEmpresa),
            'resumen'       => [
                'porCalificar'          => $this->ofertasrepository->contarContratacionesPorCalificarDePublicador($idPublicador, $esEmpresa),
                'vencenPronto'          => $this->ofertasrepository->contarOfertasQueVencenProntoDePublicador($idPublicador, $esEmpresa, self::DIAS_VENCE_PRONTO),
                'sinPostulantes'        => $this->ofertasrepository->contarOfertasSinPostulantesDePublicador($idPublicador, $esEmpresa),
                'postulantesPorRevisar' => $this->ofertasrepository->contarPostulantesPorRevisarDePublicador($idPublicador, $esEmpresa),
            ],
            'calificacion'  => $this->ofertasrepository->reputacionDePublicador($idPublicador, $esEmpresa),
        ];
    }

    /** Con contratación gana sobre vencida: si ya contrataste, ese es el resultado de la oferta. */
    private function estadoDeOferta(int $contratadas, $fechaLimite): string
    {
        if ($contratadas > 0) {
            return 'con_contratacion';
        }

        if (Carbon::parse($fechaLimite)->toDateString() < Carbon::now('America/Bogota')->toDateString()) {
            return 'vencida';
        }

        return 'activa';
    }

    private function validarFiltrosMisOfertas(array $filtros): void
    {
        if (! empty($filtros['estado']) && ! in_array($filtros['estado'], self::ESTADOS_OFERTA, true)) {
            throw new InvalidArgumentException('El estado seleccionado no es válido.');
        }

        if (! empty($filtros['orden']) && ! in_array($filtros['orden'], self::ORDENES, true)) {
            throw new InvalidArgumentException('El orden seleccionado no es válido.');
        }
    }

    public function actualizarMiOferta(int $id, array $datos, Usuario|Empresa $cuenta)
    {
        $esEmpresa = $cuenta instanceof Empresa;
        $oferta = $this->ofertasrepository->buscarOfertaDePublicador($id, $cuenta->id, $esEmpresa);

        if ($this->ofertasrepository->tienePostulanteContratado($id)) {
            throw new Exception('Esta oferta ya tiene una persona contratada, por eso no se puede editar.');
        }

        if (Carbon::parse($oferta->fechaLimite)->toDateString() < Carbon::now('America/Bogota')->toDateString()) {
            throw new Exception('Esta oferta ya venció, por eso no se puede editar.');
        }

        // Quien publica no se puede cambiar desde el formulario.
        unset($datos['idUsuario'], $datos['idEmpresa']);

        return $this->actualizar($id, $datos);
    }

    /** "Postulantes de una oferta" (quien publicó decide sobre ellos) */
    public function datosPostulantes(int $idOferta, array $filtros, Usuario|Empresa $cuenta): array
    {
        $this->validarFiltrosPostulaciones($filtros); // mismos estados y órdenes de "Mis postulaciones"

        $esEmpresa = $cuenta instanceof Empresa;
        $idPublicador = $cuenta->id;
        $usuario = $esEmpresa ? null : $cuenta;

        $oferta = $this->buscarOfertaPropia($idOferta, $idPublicador, $esEmpresa);

        $postulantes = $this->ofertasrepository->listarPostulantesPaginados($idOferta, $filtros, self::POR_PAGINA);
        $hojas = $this->ofertasrepository->hojasDeVidaPorUsuario($postulantes->pluck('idUsuario')->all());
        $calificaciones = $this->ofertasrepository->calificacionesPorPostulacionDePublicador($postulantes->pluck('id')->all(), $idPublicador, $esEmpresa);
        $postulantes->through(function ($postulacion) use ($hojas) {
            $hoja = $hojas[$postulacion->idUsuario] ?? null;

            $postulacion->hojaDeVida = $hoja;
            $postulacion->perfilCompleto = $this->perfilCompleto($hoja);
            $postulacion->calificacion = $calificaciones[$postulacion->id] ?? null; // puntuación, o null si aún no calificas

            return $postulacion;
        });

        $porEstado = $this->ofertasrepository->contarPostulantesPorOferta([$idOferta])[$idOferta] ?? [];

        $oferta->categoria = $this->ofertasrepository->categoriasPorOferta([$idOferta])[$idOferta] ?? null;
        $oferta->estadoOferta = $this->estadoDeOferta($porEstado['Contratado'] ?? 0, $oferta->fechaLimite);

        return [
            'nombre'      => $esEmpresa ? $cuenta->nombreEmpresa : trim($cuenta->nombres . ' ' . $cuenta->apellidos),
            'idUsuario'   => $usuario?->id,
            'idEmpresa'   => $esEmpresa ? $cuenta->id : null,
            'esEmpresa'    => $esEmpresa,
            'oferta'      => $oferta,
            'postulantes' => $postulantes,
            'conteos'     => [
                'todos'      => array_sum($porEstado),
                'Enviado'    => $porEstado['Enviado'] ?? 0,
                'Aceptado'   => $porEstado['Aceptado'] ?? 0,
                'Contratado' => $porEstado['Contratado'] ?? 0,
                'Rechazado'  => $porEstado['Rechazado'] ?? 0,
            ],
        ];
    }

    /** Solo quien publicó la oferta puede ver sus postulantes. */
    private function buscarOfertaPropia(int $idOferta, int $idPublicador, bool $esEmpresa)
    {
        try {
            return $this->ofertasrepository->buscarOfertaDePublicador($idOferta, $idPublicador, $esEmpresa);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Esa oferta no existe o no es tuya.');
        }
    }

    /** "Perfil completo" = los 4 campos de texto de la hoja de vida están llenos. */
    private function perfilCompleto($hoja): bool
    {
        if (! $hoja) {
            return false;
        }

        return collect(['ubicacion', 'nivelEducativo', 'perfilProfesional', 'experienciaLaboral'])
            ->every(fn ($campo) => filled($hoja->{$campo}));
    }
}
