<?php

namespace App\Repositories;
use App\Models\Servicios;

use App\Models\Categoria;

class categoriasRepository{

    public function listarTodos()
    {
        $categorias = Categoria::all();
        return $categorias;
    }

    public function guardar(array $datos)
    {
        Categoria::create($datos);
    }

    public function eliminar (int $id)
    {
        Categoria::destroy($id);
    }

    public function buscarPorId(int $id)
    {
        $categoria = Categoria::findOrFail($id);
        return $categoria;
    }

    public function actualizar(int $id, array $datos)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($datos);
    }

    public function listarPaginado(string $buscar, int $porPagina)
    {
        return Categoria::query()->when($buscar !== '', fn ($q) => $q->where('nombre', 'like', "%{$buscar}%"))
            ->orderBy('id')
            ->paginate($porPagina)
            ->withQueryString(); // conserva ?buscar=... al cambiar de página
    }

    public function tieneServicios(int $id): bool
    {
        return Servicios::where('idCategoria', $id)->exists();
    }
}

