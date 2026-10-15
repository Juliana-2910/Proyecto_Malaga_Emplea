<?php

namespace App\Services;

use App\Repositories\ofertaServiciosRepository;

class ofertaServiciosService
{
    private ofertaServiciosRepository $ofertaServiciosRepository;

    public function __construct(ofertaServiciosRepository $ofertaServiciosRepository)
    {
        $this->ofertaServiciosRepository = $ofertaServiciosRepository;
    }

    public function listarTodos()
    {
        return $this->ofertaServiciosRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $this->ofertaServiciosRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->ofertaServiciosRepository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
        return $this->ofertaServiciosRepository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $this->ofertaServiciosRepository->actualizar($id, $datos);
    }
}
