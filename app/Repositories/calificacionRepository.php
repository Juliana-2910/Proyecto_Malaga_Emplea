<?php

namespace App\Repositories;

use App\Models\Calificacion;
use App\Models\Postulacion;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class calificacionRepository{

    public function listarTodos()
    {
        return Calificacion::with(['usuario','empresa','usuarioCalificado','empresaCalificada',
            'postulacion.usuario', 'postulacion.oferta.empresa', 'postulacion.oferta.usuario'
        ])->get();
    }

    public function historialDeCuenta(Usuario|Empresa $cuenta)
    {
        $esEmpresa = $cuenta instanceof Empresa;
        $columnaAutor = $esEmpresa ? 'idEmpresa' : 'idUsuario';
        $columnaDestino = $esEmpresa ? 'idEmpresaCalificada' : 'idUsuarioCalificado';

        return Calificacion::with([
            'usuario',
            'empresa',
            'usuarioCalificado',
            'empresaCalificada',
            'postulacion.oferta',
        ])
            ->whereHas('postulacion', fn ($query) => $query->where('estado', 'Contratado'))
            ->where(fn ($query) => $query
                ->where($columnaAutor, $cuenta->id)
                ->orWhere($columnaDestino, $cuenta->id))
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->get();
    }

    public function guardar(array $datos)
    {
        return Calificacion::create($datos);
    }

    public function eliminar (int $id)
    {
        $calificacion = Calificacion::findOrFail($id);
        return $calificacion->delete();
    }

    public function buscarPorId(int $id)
    {
        return Calificacion::findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $calificacion = Calificacion::FindOrFail($id);
        $calificacion->update($datos);
        return $calificacion;
    }

    // Reputación promedio de las empresas (calificaciones que recibieron)
    public function listarReputacionEmpresas()
    {
        return DB::select("
            SELECT
                e.id,
                e.nombreEmpresa,
                (
                    SELECT AVG(c.puntuacion)
                    FROM calificacion AS c
                    WHERE c.idEmpresaCalificada = e.id
                ) AS reputacion,
                (
                    SELECT COUNT(*)
                    FROM calificacion AS c
                    WHERE c.idEmpresaCalificada = e.id
                ) AS totalCalificaciones
            FROM empresas AS e
            WHERE EXISTS (
                SELECT 1
                FROM calificacion AS c
                WHERE c.idEmpresaCalificada = e.id
            )
        ");
    }

    // Reputación promedio de las personas naturales (calificaciones que recibieron)
    public function listarReputacionUsuarios()
    {
        return DB::select("
            SELECT
                u.id,
                u.nombres,
                u.apellidos,
                (
                    SELECT AVG(c.puntuacion)
                    FROM calificacion AS c
                    WHERE c.idUsuarioCalificado = u.id
                ) AS reputacion,
                (
                    SELECT COUNT(*)
                    FROM calificacion AS c
                    WHERE c.idUsuarioCalificado = u.id
                ) AS totalCalificaciones
            FROM usuarios AS u
            WHERE EXISTS (
                SELECT 1
                FROM calificacion AS c
                WHERE c.idUsuarioCalificado = u.id
            )
        ");
    }

    /** Postulación con su oferta, para calificar una contratación. */
    public function buscarPostulacionConOferta(int $idPostulacion)
    {
        return Postulacion::with('oferta')->findOrFail($idPostulacion);
    }

    /** ¿Esta persona ya calificó esta postulación? */
    public function yaCalificadaPorUsuario(int $idPostulacion, int $idUsuario): bool
    {
        return Calificacion::where('idPostulacion', $idPostulacion)
            ->where('idUsuario', $idUsuario)
            ->exists();
    }

    /** ¿Ya existe una calificación de este sentido en la postulación? */
    public function yaCalificadaPorSentido(int $idPostulacion, string $tipoCalificador): bool
    {
        return Calificacion::where('idPostulacion', $idPostulacion)
            ->where('tipoCalificador', $tipoCalificador)
            ->exists();
    }

    /** Lista las postulaciones contratadas para el formulario administrativo. */
    public function listarPostulacionesContratadas()
    {
        return Postulacion::with([
            'usuario',
            'oferta.empresa',
            'oferta.usuario'
        ])
        ->where('estado', 'Contratado')
        ->orderByDesc('id')
        ->get();
    }
}
