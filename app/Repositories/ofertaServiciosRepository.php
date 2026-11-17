<?php

namespace App\Repositories;

use App\Models\OfertaServicios;
use App\Models\Postulacion;

class ofertaServiciosRepository
{
    public function listarTodos()
    {
        return OfertaServicios::all();
    }

    public function guardar(array $datos)
    {
        return OfertaServicios::create($datos);
    }

    public function eliminar(int $id)
    {
        OfertaServicios::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return OfertaServicios::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $postulacion = OfertaServicios::findOrFail($id);

        $postulacion->update($datos);
    }

    public function actualizarPorOferta(int $idOferta, int $idServicio)
    {
        return OfertaServicios::updateOrCreate(['idOferta' => $idOferta],['idServicio' => $idServicio]);
    }

    public function listarPaginado(string $buscar, int $porPagina)
    {
        return OfertaServicios::with(['oferta', 'servicio'])
            ->when($buscar !== '', function ($q) use ($buscar) {
                foreach (preg_split('/\s+/', $buscar) as $palabra) {
                    $q->where(function ($q) use ($palabra) {
                        $q->whereHas('oferta', fn ($o) => $o->where('titulo', 'like', "%{$palabra}%"))
                        ->orWhereHas('servicio', fn ($s) => $s->where('nombre', 'like', "%{$palabra}%"));
                    });
                }
            })
            ->orderBy('id')
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function ofertaTienePostulaciones(int $idOferta): bool
    {
        return Postulacion::where('idOferta', $idOferta)->exists();
    }
}
