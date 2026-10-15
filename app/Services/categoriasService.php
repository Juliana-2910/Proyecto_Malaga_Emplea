<?php

namespace App\Services;

use App\Repositories\categoriasRepository;

class categoriasService{

    private categoriasRepository $categoriasRepository;

    public function __construct(categoriasRepository $categoriasRepository)
    {
        $this->categoriasRepository = $categoriasRepository;
    }

    public function listarTodos()
    {
        return $this->categoriasRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $this->categoriasRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->categoriasRepository->eliminar($id);
    }

    public function buscarPorId(int $id)
    {
        return $this->categoriasRepository->buscarPorId($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $this->categoriasRepository->actualizar($id, $datos);
    }
}
