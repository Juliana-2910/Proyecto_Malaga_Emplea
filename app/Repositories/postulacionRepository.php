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

    public function listarPorUsuario(int $idUsuario)
    {
        return Postulacion::where('idUsuario', $idUsuario)
            ->orderBy('fecha', 'desc')
            ->get();
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

    public function buscarConOferta(int $id)
    {
        return Postulacion::with('oferta')->findOrFail($id);
    }

    /** Relee la postulación con bloqueo para observar decisiones concurrentes ya confirmadas. */
    public function buscarConOfertaBloqueada(int $id)
    {
        return Postulacion::with('oferta')->lockForUpdate()->findOrFail($id);
    }

    public function existeOtraContratacion(int $idOferta, int $idPostulacion): bool
    {
        return Postulacion::where('idOferta', $idOferta)
            ->where('estado', 'Contratado')
            ->where('id', '<>', $idPostulacion)
            ->exists();
    }

    /** Serializa las contrataciones de una misma oferta dentro de una transacción. */
    public function bloquearOfertaParaContratar(int $idOferta): void
    {
        Oferta::whereKey($idOferta)->lockForUpdate()->firstOrFail();
    }

    /** Rechaza todas las postulaciones que seguían en proceso al contratar una persona. */
    public function rechazarPendientesDeOferta(int $idOferta, int $idPostulacionContratada): void
    {
        Postulacion::where('idOferta', $idOferta)
            ->where('id', '<>', $idPostulacionContratada)
            ->whereIn('estado', ['Enviado', 'Aceptado'])
            ->update(['estado' => 'Rechazado']);
    }

    public function actualizar(int $id, array $datos)
    {
        $postulacion = Postulacion::findOrFail($id);

        $postulacion->update($datos);
    }

    public function buscarUsuario(int $id)
    {
        return Usuario::findOrFail($id);
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
