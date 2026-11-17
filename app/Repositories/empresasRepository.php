<?php

namespace App\Repositories;

use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\Calificacion;
use Illuminate\Support\Facades\DB;

class empresasRepository{

public function listarTodos()
{
        return Empresa::all();
    }

    public function guardar(array $datos)
    {
        return Empresa::create($datos);
    }

    public function eliminar(int $id)
    {
        return Empresa::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return Empresa::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
    $empresa = Empresa::findOrFail($id);

        if (empty($datos['password'])) {
            unset($datos['password']);
        }

        return $empresa->update($datos);
    }

    // Subconsulta: empresas que tienen ofertas
    public function listarEmpresasConOfertas()
    {
        return DB::select("
            SELECT id, nombreEmpresa
            FROM empresas
            WHERE id IN (
                SELECT idEmpresa
                FROM ofertas
            )
        ");
    }

    public function listarPaginado(string $buscar, int $porPagina)
    {
        return Empresa::query()
            ->when($buscar !== '', function ($q) use ($buscar) {
                foreach (preg_split('/\s+/', $buscar) as $palabra) {
                    $q->where(function ($q) use ($palabra) {
                        $q->where('nombreEmpresa', 'like', "%{$palabra}%")
                        ->orWhere('nit', 'like', "%{$palabra}%")
                        ->orWhere('direccion', 'like', "%{$palabra}%")
                        ->orWhere('email', 'like', "%{$palabra}%");
                    });
                }
            })
            ->orderBy('id')
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function tieneOfertas(int $id): bool
    {
        return Oferta::where('idEmpresa', $id)->exists();
    }

    public function tieneCalificaciones(int $id): bool
    {
        return Calificacion::where(function ($q) use ($id) {
            $q->where('idEmpresa', $id)
            ->orWhere('idEmpresaCalificada', $id);
        })->exists();
    }

}
