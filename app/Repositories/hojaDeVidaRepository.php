<?php

namespace App\Repositories;

use App\Models\HojaDeVida;

class hojaDeVidaRepository
{
    public function listarTodos()
    {
        return HojaDeVida::all();
    }

    public function guardar(array $datos)
    {
        return HojaDeVida::create($datos);
    }

    public function buscarPorId(int $id)
    {
        return HojaDeVida::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $hojaDeVida = $this->buscarPorId($id);
        $hojaDeVida->update($datos);
    }

    public function eliminar(int $id)
    {
        $hojaDeVida = $this->buscarPorId($id);
        $hojaDeVida->delete();
    }

    public function existePorUsuario(int $idUsuario): bool
    {
        return HojaDeVida::where('idUsuario', $idUsuario)->exists();
    }

    public function buscarPorUsuario(int $idUsuario)
    {
        return HojaDeVida::where('idUsuario', $idUsuario)->first();
    }

    public function listarPaginado(string $buscar, int $porPagina)
    {
        return HojaDeVida::with('usuario')
            ->when($buscar !== '', function ($q) use ($buscar) {
                foreach (preg_split('/\s+/', $buscar) as $palabra) {
                    $q->where(function ($q) use ($palabra) {
                        $q->where('ubicacion', 'like', "%{$palabra}%")
                        ->orWhere('nivelEducativo', 'like', "%{$palabra}%")
                        ->orWhere('perfilProfesional', 'like', "%{$palabra}%")
                        ->orWhere('experienciaLaboral', 'like', "%{$palabra}%")
                        ->orWhereHas('usuario', fn ($u) => $u->where('nombres', 'like', "%{$palabra}%")
                                                            ->orWhere('apellidos', 'like', "%{$palabra}%"));
                    });
                }
            })
            ->orderBy('id')
            ->paginate($porPagina)
            ->withQueryString();
    }
}
