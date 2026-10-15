<?php

namespace App\Services;

use App\Repositories\serviciosRepository;

class serviciosService{

    private serviciosRepository $serviciosRepository;

    public function __construct(serviciosRepository $serviciosRepository)
    {
        $this->serviciosRepository = $serviciosRepository;
    }

    public function listarTodos()
    {
        return $this->serviciosRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $this->serviciosRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->serviciosRepository->eliminar($id);
    }

    public function buscarPorId(int $id)
    {
        return $this->serviciosRepository->buscarPorId($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $this->serviciosRepository->actualizar($id, $datos);
    }
}
