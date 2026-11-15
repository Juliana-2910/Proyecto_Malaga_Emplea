<?php

namespace App\Services;

use App\Repositories\serviciosRepository;
use InvalidArgumentException;

class serviciosService{

    private serviciosRepository $serviciosRepository;
    private const POR_PAGINA = 10;

    public function __construct(serviciosRepository $serviciosRepository)
    {
        $this->serviciosRepository = $serviciosRepository;
    }

    public function listarTodos()
    {
        return $this->serviciosRepository->listarTodos();
    }

    public function listarPorCategoria(int $idCategoria)
    {
        return $this->serviciosRepository->listarPorCategoria($idCategoria);
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

    public function listarPaginado(array $filtros)
    {
        $buscar = trim((string) ($filtros['buscar'] ?? ''));
        $this->validarBusqueda($buscar);
        return $this->serviciosRepository->listarPaginado($buscar, self::POR_PAGINA);
    }

    private function validarBusqueda(string $buscar): void
    {
        if (mb_strlen($buscar) > 100) {
            throw new InvalidArgumentException('La búsqueda no puede superar los 100 caracteres.');
        }
    }
}
