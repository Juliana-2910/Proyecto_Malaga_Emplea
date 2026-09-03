<?php

namespace App\Services;

use App\Repositories\hojaDeVidaRepository;

class hojaDeVidaService{

    private hojaDeVidaRepository $hojaDeVidaRepository;

    public function __construct(hojaDeVidaRepository $hojaDeVidaRepository)
    {
        $this->hojaDeVidaRepository = $hojaDeVidaRepository;
    }

    public function listarTodos()
    {
        return $this->hojaDeVidaRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $this->hojaDeVidaRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->hojaDeVidaRepository->eliminar($id);
    }

    public function buscarPorId(int $id)
    {
        return $this->hojaDeVidaRepository->buscarPorId($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $this->hojaDeVidaRepository->actualizar($id, $datos);
    }
}
