<?php

namespace App\Services;

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
        $this->calificacionRepository->actualizar($id, $datos);
    }
}
