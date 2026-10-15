<?php

namespace App\Services;

use App\Repositories\postulacionRepository;

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
        $this->postulacionrepository->guardar($datos);
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
        $this->postulacionrepository->actualizar($id, $datos);
    }
}