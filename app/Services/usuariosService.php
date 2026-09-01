<?php

namespace App\Repositories;

use App\Repositories\usuariosRepository;

class usuariosService{

    private usuariosRepository $usuariosRepository;

    public function __construct(usuariosRepository $usuariosRepository)
    {
        $this->usuariosRepository = $usuariosRepository;
    }

    public function listarTodos()
    {
        return $this->usuariosRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $this->usuariosRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->usuariosRepository->eliminar($id);
    }

    public function buscarPorId(int $id)
    {
        return $this->usuariosRepository->buscarPorId($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $this->usuariosRepository->actualizar($id, $datos);
    }
}
