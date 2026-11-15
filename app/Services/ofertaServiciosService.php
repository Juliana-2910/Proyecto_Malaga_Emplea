<?php

namespace App\Services;

use App\Repositories\ofertaServiciosRepository;
use InvalidArgumentException;

class ofertaServiciosService
{
    private ofertaServiciosRepository $ofertaServiciosRepository;
    private const POR_PAGINA = 10;

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

    public function listarPaginado(array $filtros)
    {
        $buscar = trim((string) ($filtros['buscar'] ?? ''));

        if (mb_strlen($buscar) > 100) {
            throw new InvalidArgumentException('La búsqueda no puede superar los 100 caracteres.');
        }

        return $this->ofertaServiciosRepository->listarPaginado($buscar, self::POR_PAGINA);
    }
}
