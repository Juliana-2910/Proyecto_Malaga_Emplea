<?php

namespace App\Services;

use App\Repositories\postulacionRepository;
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

        $this->postulacionrepository->actualizar($id, [
            'idUsuario' => $usuario->id,
            'idOferta'  => $oferta->id,
        ]);
    }

    private function validarUsuarioPuedePostular($usuario)
    {
        if ($usuario->estado !== 'Activo') {
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
}
