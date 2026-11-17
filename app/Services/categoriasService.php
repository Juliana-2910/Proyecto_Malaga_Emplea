<?php

namespace App\Services;
use App\Repositories\categoriasRepository;
use Exception;
use InvalidArgumentException;

class categoriasService{

    private categoriasRepository $categoriasRepository;
    private const POR_PAGINA = 10;

    public function __construct(categoriasRepository $categoriasRepository)
    {
        $this->categoriasRepository = $categoriasRepository;
    }

    public function listarTodos()
    {
        return $this->categoriasRepository->listarTodos();
    }

    public function listarPaginado(array $filtros)
    {
        $buscar = trim((string) ($filtros['buscar'] ?? ''));

        $this->validarBusqueda($buscar);

        return $this->categoriasRepository->listarPaginado($buscar, self::POR_PAGINA);
    }

    public function guardar(array $datos)
    {
        $this->categoriasRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->validarSinServicios($id);

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

    private function validarBusqueda(string $buscar): void
    {
        if (mb_strlen($buscar) > 100) {
            throw new InvalidArgumentException('La búsqueda no puede superar los 100 caracteres.');
        }
    }

    private function validarSinServicios(int $id): void
    {
        if ($this->categoriasRepository->tieneServicios($id)) {
            throw new Exception('No se puede eliminar esta categoría porque tiene servicios relacionados.');
        }
    }
}
