<?php

namespace App\Repositories;

use App\Models\Postulacion;
use App\Models\Usuario;
use App\Models\Oferta;

class postulacionRepository
{
    public function listarTodos()
    {
        return Postulacion::all();
    }

    public function guardar(array $datos)
    {
        Postulacion::create($datos);
    }

    public function eliminar(int $id)
    {
        Postulacion::destroy($id);
    }

    public function buscarporid(int $id)
    {
        return Postulacion::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $postulacion = Postulacion::findOrFail($id);

        $postulacion->update($datos);
    }

    public function buscarUsuario(int $id)
    {
        return Usuario::with('rol')->findOrFail($id);
    }

    public function buscarOferta(int $id)
    {
        return Oferta::findOrFail($id);
    }

    public function yaPostulado(
        int $idUsuario,
        int $idOferta,
        ?int $idPostulacion = null
    ): bool {
        return Postulacion::where('idUsuario', $idUsuario)
            ->where('idOferta', $idOferta)
            ->when($idPostulacion !== null, function ($query) use ($idPostulacion) {
                $query->where('id', '!=', $idPostulacion);
            })
            ->exists();
    }

    public function tienePostulacionesEnCurso(int $idUsuario): bool
    {
        return Postulacion::where('idUsuario', $idUsuario)
            ->whereIn('estado', ['Enviado', 'Aceptado'])
            ->exists();
    }
}
