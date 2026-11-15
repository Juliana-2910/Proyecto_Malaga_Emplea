<?php

namespace App\Repositories;

use App\Models\Servicios;

class serviciosRepository{

    public function listarTodos()
    {
        $servicios = Servicios::all();
        return $servicios;
    }

    public function listarPorCategoria(int $idCategoria)
    {
        return Servicios::where('idCategoria', $idCategoria)
            ->orderBy('nombre')
            ->get();
    }

    public function guardar(array $datos)
    {
        Servicios::create($datos);
    }

    public function eliminar (int $id)
    {
        Servicios::destroy($id);
    }

    public function buscarPorId(int $id)
    {
        $servicio = Servicios::findOrFail($id);
        return $servicio;
    }

    public function actualizar(int $id, array $datos)
    {
        $servicio = Servicios::findOrFail($id);
        $servicio->update($datos);
    }

    public function listarPaginado(string $buscar, int $porPagina)
    {
        return Servicios::query()
            ->with('categoria') // evita consultas repetidas por cada fila
            ->when($buscar !== '', function ($q) use ($buscar) {
                $q->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%")
                    ->orWhereHas('categoria', fn ($c) => $c->where('nombre', 'like', "%{$buscar}%"));
                });
            })
            ->orderBy('id')
            ->paginate($porPagina)
            ->withQueryString(); // conserva ?buscar=... al cambiar de página
    }
}

