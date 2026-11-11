<?php

namespace App\Services;

use App\Repositories\postulacionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

class postulacionService
{
    private postulacionRepository $postulacionrepository;

    public function __construct(postulacionRepository $postulacionrepository)
    {
        $this->postulacionrepository = $postulacionrepository;
    }

    public function listarTodos()
    {
        return $this->postulacionrepository->listarTodos();
    }

    public function listarPorUsuario(int $idUsuario)
    {
        return $this->postulacionrepository->listarPorUsuario($idUsuario);
    }

    public function guardar(array $datos)
    {
        $usuario = $this->postulacionrepository->buscarUsuario(
            (int) $datos['idUsuario']
        );

        $oferta = $this->postulacionrepository->buscarOferta(
            (int) $datos['idOferta']
        );

        $this->validarUsuarioPuedePostular($usuario);
        $this->validarOfertaVigente($oferta);
        $this->validarOfertaSinContratacion($oferta);
        $this->validarNoDuplicada($usuario->id, $oferta->id);
        $this->validarNoEsDuenoDeLaOferta($usuario, $oferta);

        $this->postulacionrepository->guardar([
            'fecha'     => $this->obtenerFechaActual(),
            'estado'    => $this->obtenerEstadoInicial(),
            'idUsuario' => $usuario->id,
            'idOferta'  => $oferta->id,
        ]);
    }

    public function eliminar(int $id)
    {
        $this->postulacionrepository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
        return $this->postulacionrepository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $postulacion = $this->postulacionrepository->buscarporid($id);

        $usuario = $this->postulacionrepository->buscarUsuario(
            (int) $datos['idUsuario']
        );

        $oferta = $this->postulacionrepository->buscarOferta(
            (int) $datos['idOferta']
        );

        $this->validarUsuarioPuedePostular($usuario);
        $this->validarOfertaVigente($oferta);

        $this->validarNoDuplicada(
            $usuario->id,
            $oferta->id,
            $postulacion->id
        );

        $this->validarNoEsDuenoDeLaOferta($usuario, $oferta);

        $this->validarCambioEstado(
        $postulacion->estado,
        $datos['estado']
    );

        $this->postulacionrepository->actualizar($id, [
            'idUsuario' => $usuario->id,
            'idOferta'  => $oferta->id,
            'estado'     => $datos['estado']
        ]);
    }

    private function validarUsuarioPuedePostular($usuario)
    {
        if (strtolower((string) $usuario->estado) !== 'activo') {
            throw new Exception(
                'El usuario está inactivo y no puede postularse.'
            );
        }
    }

    private function validarOfertaVigente($oferta)
    {
        $hoy = Carbon::parse($this->obtenerFechaActual());

        if ($hoy->gt(Carbon::parse($oferta->fechaLimite))) {
            throw new Exception(
                'La oferta ya venció y no admite postulaciones.'
            );
        }
    }

    private function validarNoDuplicada(
        int $idUsuario,
        int $idOferta,
        ?int $idPostulacion = null
    ) {
        if ($this->postulacionrepository->yaPostulado(
            $idUsuario,
            $idOferta,
            $idPostulacion
        )) {
            throw new Exception(
                'Ya existe una postulación de este usuario a esta oferta.'
            );
        }
    }

    private function obtenerFechaActual(): string
    {
        return Carbon::now('America/Bogota')->toDateString();
    }

    private function obtenerEstadoInicial(): string
    {
        return 'Enviado';
    }

    private function validarCambioEstado(string $estadoActual, string $nuevoEstado
    ) {
        if ($estadoActual === $nuevoEstado) {
            return;
        }

        $estadosPermitidos = [
            'Enviado' => ['Aceptado', 'Rechazado'],
            'Aceptado' => ['Contratado', 'Rechazado'],
            'Rechazado' => [],
            'Contratado' => [],
        ];

        if (!in_array($nuevoEstado, $estadosPermitidos[$estadoActual] ?? [], true)) {
            throw new Exception(
                'No se permite cambiar el estado de '
                . $estadoActual . ' a ' . $nuevoEstado . '.'
            );
        }
    }

    private function validarNoEsDuenoDeLaOferta($usuario, $oferta)
    {
        if (
            $oferta->idUsuario !== null
            && (int) $oferta->idUsuario === (int) $usuario->id
        ) {
            throw new Exception(
                'No puedes postularte a una oferta que tú publicaste.'
            );
        }
    }

    /* ===== Cancelar postulación (usuario) ===== */
    public function cancelar(int $idPostulacion, int $idUsuario)
    {
        try {
            $postulacion = $this->postulacionrepository->buscarporid($idPostulacion);
        } catch (ModelNotFoundException $e) {
            throw new Exception('La postulación no existe o ya fue cancelada.');
        }

        $this->validarPostulacionEsDeLaPersona($postulacion, $idUsuario);
        $this->validarPostulacionSigueEnviada($postulacion);

        $this->postulacionrepository->eliminar($idPostulacion);
    }

    private function validarPostulacionEsDeLaPersona($postulacion, int $idUsuario)
    {
        if ((int) $postulacion->idUsuario !== $idUsuario) {
            throw new Exception('No puedes cancelar una postulación que no es tuya.');
        }
    }

    private function validarPostulacionSigueEnviada($postulacion)
    {
        if ($postulacion->estado !== $this->obtenerEstadoInicial()) {
            throw new Exception('Solo puedes cancelar postulaciones que aún están en estado Enviado.');
        }
    }

    /* ===== Decisiones de quien publica la oferta ===== */

    public function aceptar(int $idPostulacion, int $idPublicador): void
    {
        $postulacion = $this->buscarPostulacionDelPublicador($idPostulacion, $idPublicador);

        $this->validarOfertaSinContratado((int) $postulacion->idOferta);
        $this->validarEstadoActual($postulacion, 'Enviado', 'aceptar');
        $this->validarCambioEstado($postulacion->estado, 'Aceptado'); // reutiliza tu tabla de transiciones

        $this->postulacionrepository->actualizar($idPostulacion, ['estado' => 'Aceptado']);
    }

    private function buscarPostulacionDelPublicador(int $idPostulacion, int $idPublicador)
    {
        try {
            $postulacion = $this->postulacionrepository->buscarConOferta($idPostulacion);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Esa postulación no existe.');
        }

        // Solo decide quien publicó la oferta
        if ((int) $postulacion->oferta->idUsuario !== $idPublicador) {
            throw new Exception('Solo puedes decidir sobre postulaciones de tus ofertas.');
        }

        return $postulacion;
    }

    private function validarOfertaSinContratado(int $idOferta): void
    {
        if ($this->postulacionrepository->ofertaTieneContratado($idOferta)) {
            throw new Exception('Esta oferta ya tiene una persona contratada, por eso no se pueden tomar más decisiones.');
        }
    }

    private function validarEstadoActual($postulacion, string $esperado, string $accion): void
    {
        if ($postulacion->estado !== $esperado) {
            throw new Exception("Solo puedes {$accion} postulaciones en estado {$esperado}.");
        }
    }

    public function contratar(int $idPostulacion, int $idPublicador): void
    {
        // Todo o nada: si algo falla, no queda una persona contratada con las demás sin rechazar.
        DB::transaction(function () use ($idPostulacion, $idPublicador) {
            $postulacion = $this->buscarPostulacionDelPublicador($idPostulacion, $idPublicador);

            $this->validarOfertaSinContratado((int) $postulacion->idOferta);
            $this->validarEstadoActual($postulacion, 'Aceptado', 'contratar'); // solo se contrata a quien ya aceptaste
            $this->validarCambioEstado($postulacion->estado, 'Contratado');

            $this->postulacionrepository->actualizar($idPostulacion, ['estado' => 'Contratado']);

            // Una sola persona por oferta: las demás quedan rechazadas
            $this->postulacionrepository->rechazarPendientesDeOferta((int) $postulacion->idOferta, $idPostulacion);
        });
    }

    /** Una oferta con persona contratada ya no recibe postulaciones nuevas. */
    private function validarOfertaSinContratacion($oferta): void
    {
        if ($this->postulacionrepository->ofertaTieneContratado((int) $oferta->id)) {
            throw new Exception('Esta oferta ya tiene una persona contratada y no admite más postulaciones.');
        }
    }

    public function rechazar(int $idPostulacion, int $idPublicador): void
    {
        $postulacion = $this->buscarPostulacionDelPublicador($idPostulacion, $idPublicador);

        $this->validarOfertaSinContratado((int) $postulacion->idOferta);
        $this->validarEstadoActual($postulacion, 'Enviado', 'rechazar'); // quien ya fue aceptado solo avanza a contratado
        $this->validarCambioEstado($postulacion->estado, 'Rechazado');

        $this->postulacionrepository->actualizar($idPostulacion, ['estado' => 'Rechazado']);
    }
}
