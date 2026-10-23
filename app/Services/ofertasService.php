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
}
