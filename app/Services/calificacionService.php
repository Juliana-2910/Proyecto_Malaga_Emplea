<?php

namespace App\Services;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Usuario;
use App\Repositories\calificacionRepository;

class calificacionService{

    private calificacionRepository $calificacionRepository;

    public function __construct(calificacionRepository $calificacionRepository)
    {
        $this->calificacionRepository = $calificacionRepository;
    }

    public function listarTodos()
    {
        return $this->calificacionRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $idPostulacion = (int) $datos['idPostulacion'];
        $tipoCalificador = $datos['tipoCalificador'];

        $this->validarCalificacionAdministrativa(
            $idPostulacion,
            $tipoCalificador
        );

        $datos = $this->prepararDatosAdministrativos($datos);

        return $this->calificacionRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->calificacionRepository->eliminar($id);
    }

    public function buscarPorId(int $id)
    {
        return $this->calificacionRepository->buscarPorId($id);

    }

    public function actualizar(int $id, array $datos)
    {
        $calificacionActual = $this->calificacionRepository->buscarPorId($id);

        $idPostulacion = (int) $datos['idPostulacion'];
        $tipoCalificador = $datos['tipoCalificador'];

        $cambioSentidoOPostulacion =
            (int) $calificacionActual->idPostulacion !== $idPostulacion ||
            $calificacionActual->tipoCalificador !== $tipoCalificador;

        if ($cambioSentidoOPostulacion) {
            $this->validarCalificacionAdministrativa(
                $idPostulacion,
                $tipoCalificador
            );
        }

        $datos = $this->prepararDatosAdministrativos($datos);

        $this->calificacionRepository->actualizar($id, $datos);
    }

    public function listarReputacionEmpresas()
    {
        return $this->calificacionRepository->listarReputacionEmpresas();
    }

    public function listarReputacionUsuarios()
    {
        return $this->calificacionRepository->listarReputacionUsuarios();
    }

    /** La persona contratada califica a quien la contrató (empresa o persona natural). */
    public function calificarContratacion(int $idPostulacion, int $idUsuario, int $puntuacion, string $comentario): void
    {
        $postulacion = $this->calificacionRepository->buscarPostulacionConOferta($idPostulacion);

        $this->validarPostulacionEsDeLaPersona($postulacion, $idUsuario);
        $this->validarContratado($postulacion);
        $this->validarNoCalificada($idPostulacion, $idUsuario);

        $oferta = $postulacion->oferta;

        $this->calificacionRepository->guardar([
            'puntuacion'          => $puntuacion,
            'comentario'          => $comentario,
            'fecha'               => Carbon::now('America/Bogota')->toDateString(),
            'idUsuario'           => $idUsuario,                                      // quien califica: la persona contratada
            'idEmpresa'           => null,
            'idEmpresaCalificada' => $oferta->idEmpresa,                              // vacío si publicó una persona
            'idUsuarioCalificado' => $oferta->idEmpresa ? null : $oferta->idUsuario,  // la persona que publicó
            'idPostulacion'       => $idPostulacion,
            'tipoCalificador'     => 'usuario',
        ]);
    }

    private function validarPostulacionEsDeLaPersona($postulacion, int $idUsuario): void
    {
        if ((int) $postulacion->idUsuario !== $idUsuario) {
            throw new Exception('No puedes calificar una postulación que no es tuya.');
        }
    }

    private function validarContratado($postulacion): void
    {
        if ($postulacion->estado !== 'Contratado') {
            throw new Exception('Solo puedes calificar cuando fuiste contratado/a.');
        }
    }

    private function validarNoCalificada(int $idPostulacion, int $idUsuario): void
    {
        if ($this->calificacionRepository->yaCalificadaPorUsuario($idPostulacion, $idUsuario)) {
            throw new Exception('Ya calificaste esta contratación. Solo se puede calificar una vez.');
        }
    }

    public function listarPostulacionesContratadas()
    {
        return $this->calificacionRepository->listarPostulacionesContratadas();
    }

    /** Validar que no exista otra calificación del mismo sentido. */
    public function validarCalificacionAdministrativa(int $idPostulacion, string $tipoCalificador): void
    {
        if ($this->calificacionRepository->yaCalificadaPorSentido($idPostulacion, $tipoCalificador)) {
            throw new Exception('Esta postulación ya tiene una calificación registrada con ese sentido.');
        }
    }

    private function prepararDatosAdministrativos(array $datos): array
    {
        $idPostulacion = (int) $datos['idPostulacion'];

        $postulacion = $this->calificacionRepository
            ->buscarPostulacionConOferta($idPostulacion);

        $this->validarContratado($postulacion);

        $oferta = $postulacion->oferta;

        if (!$oferta) {
            throw new Exception('La postulación no tiene una oferta asociada.');
        }

        $tipoCalificador = $datos['tipoCalificador'];

        $datos['fecha'] = Carbon::now('America/Bogota')->toDateString();

        if ($tipoCalificador === 'usuario') {

            // La persona contratada califica a quien publicó.
            $datos['idUsuario'] = $postulacion->idUsuario;
            $datos['idEmpresa'] = null;

            $datos['idEmpresaCalificada'] = $oferta->idEmpresa;
            $datos['idUsuarioCalificado'] = $oferta->idEmpresa
                ? null
                : $oferta->idUsuario;

        } else {

            // Quien publicó la oferta califica a la persona contratada.
            $datos['idUsuario'] = $oferta->idEmpresa
                ? null
                : $oferta->idUsuario;

            $datos['idEmpresa'] = $oferta->idEmpresa;

            $datos['idUsuarioCalificado'] = $postulacion->idUsuario;
            $datos['idEmpresaCalificada'] = null;
        }

        return $datos;
    }

    // Valor que se guarda en tipoCalificador cuando califica quien publicó la oferta.
    private const TIPO_PUBLICADOR = 'empresa';

    /** Quien publicó la oferta califica a la persona que contrató. */
    public function calificarPostulanteContratado(int $idPostulacion, int $idPublicador, int $puntuacion, string $comentario): void
    {
        try {
            $postulacion = $this->calificacionRepository->buscarPostulacionConOferta($idPostulacion);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Esa postulación no existe.');
        }

        $oferta = $postulacion->oferta;

        $this->validarOfertaEsDelPublicador($oferta, $idPublicador);
        $this->validarContratadoPorPublicador($postulacion);
        $this->validarNoCalificadaPorPublicador($idPostulacion);

        $this->calificacionRepository->guardar([
            'puntuacion'          => $puntuacion,
            'comentario'          => $comentario,
            'fecha'               => Carbon::now('America/Bogota')->toDateString(),
            'idUsuario'           => $oferta->idEmpresa ? null : $oferta->idUsuario, // quien califica: quien publicó
            'idEmpresa'           => $oferta->idEmpresa,
            'idUsuarioCalificado' => $postulacion->idUsuario,                        // la persona contratada
            'idEmpresaCalificada' => null,
            'idPostulacion'       => $idPostulacion,
            'tipoCalificador'     => self::TIPO_PUBLICADOR,
        ]);
    }

    private function validarOfertaEsDelPublicador($oferta, int $idPublicador): void
    {
        // TEMPORAL: con el login de empresa también se compara idEmpresa.
        if (! $oferta || (int) $oferta->idUsuario !== $idPublicador) {
            throw new Exception('Solo puedes calificar a quienes contrataste en tus ofertas.');
        }
    }

    private function validarContratadoPorPublicador($postulacion): void
    {
        if ($postulacion->estado !== 'Contratado') {
            throw new Exception('Solo puedes calificar a una persona que ya contrataste.');
        }
    }

    private function validarNoCalificadaPorPublicador(int $idPostulacion): void
    {
        if ($this->calificacionRepository->yaCalificadaPorSentido($idPostulacion, self::TIPO_PUBLICADOR)) {
            throw new Exception('Ya calificaste a esta persona. Solo se puede calificar una vez.');
        }
    }
}
