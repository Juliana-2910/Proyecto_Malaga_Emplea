<?php

namespace App\Services;

use App\Repositories\ofertasRepository;
use Carbon\Carbon;
use Exception;

class ofertasService
{
    private ofertasRepository $ofertasrepository;

    public function __construct(ofertasRepository $ofertasrepository)
    {
        $this->ofertasrepository = $ofertasrepository;
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
        $datos['fechaPublicacion'] = Carbon::now('America/Bogota')->toDateString();
        $this->validarSalarioMinimo($datos);
        $this->ofertasrepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        if ($this->ofertasrepository->tienePostulaciones($id)) {
            throw new Exception(
                'No se puede eliminar esta oferta porque tiene postulaciones relacionadas.'
            );
        }

        $this->ofertasrepository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
        return $this->ofertasrepository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos)
    {
        unset($datos['fechaPublicacion']);
        $this->validarSalarioMinimo($datos);
        $this->ofertasrepository->actualizar($id, $datos);
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

    private const CONTRATOS = ['tiempo completo', 'medio tiempo', 'horas'];
    private const PUBLICA = ['empresas', 'personas'];
    private const ORDENES = ['recientes', 'antiguas', 'vencen'];
    private const POR_PAGINA = 10;

    public function datosListadoUsuario(array $filtros): array
    {
        $this->validarFiltros($filtros);

        // TEMPORAL: cuando exista el login, el usuario sale de auth().
        $usuario = $this->ofertasrepository->usuarioDePrueba();
        $idUsuario = $usuario?->id;

        $ofertas = $this->ofertasrepository->listarActivas($filtros, self::POR_PAGINA);

        $categoriasPorOferta = $this->ofertasrepository->categoriasPorOferta($ofertas->pluck('id')->all());
        $postuladas = $idUsuario ? $this->ofertasrepository->idsOfertasPostuladas($idUsuario) : [];

        $ofertas->through(function ($oferta) use ($categoriasPorOferta, $postuladas) {
            $oferta->publicador = $this->nombrePublicador($oferta);
            $oferta->categoria = $categoriasPorOferta[$oferta->id] ?? null;
            $oferta->postulado = in_array($oferta->id, $postuladas, true);
            return $oferta;
        });

        $porEstado = $idUsuario ? $this->ofertasrepository->contarPostulacionesPorEstado($idUsuario) : [];

        return [
            'nombre'                => $usuario?->nombres ?? 'Usuario',
            'esEmpresa'             => false, // TEMPORAL: se define con el login
            'totalOfertas'          => $ofertas->total(),
            'ofertas'               => $ofertas,
            'categorias'            => $this->ofertasrepository->listarCategorias(),
            'resumenPostulaciones'  => [
                'enviadas'   => $porEstado['Enviado'] ?? 0,
                'aceptadas'  => $porEstado['Aceptado'] ?? 0,
                'rechazadas' => $porEstado['Rechazado'] ?? 0,
            ],
            'postulantesPorRevisar' => $idUsuario ? $this->ofertasrepository->contarPostulantesPorRevisar($idUsuario) : 0,
            'hojaDeVidaProgreso'    => $idUsuario ? $this->progresoHojaDeVida($idUsuario) : 0,
        ];
    }

    private function validarFiltros(array $filtros): void
    {
        if (! empty($filtros['contrato']) && ! in_array($filtros['contrato'], self::CONTRATOS, true)) {
            throw new \Exception('El tipo de contrato seleccionado no es válido.');
        }

        if (! empty($filtros['publica']) && ! in_array($filtros['publica'], self::PUBLICA, true)) {
            throw new \Exception('La opción "Publicada por" no es válida.');
        }

        if (! empty($filtros['orden']) && ! in_array($filtros['orden'], self::ORDENES, true)) {
            throw new \Exception('El orden seleccionado no es válido.');
        }

        if (! empty($filtros['categoria']) && ! ctype_digit((string) $filtros['categoria'])) {
            throw new \Exception('La categoría seleccionada no es válida.');
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
}
