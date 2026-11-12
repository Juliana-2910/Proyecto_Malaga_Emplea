<?php

namespace App\Repositories;

use App\Models\Calificacion;
use App\Models\Postulacion;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class calificacionRepository{

    public function buscarCuentaCalificable(string $tipo, int $id): Usuario|Empresa
    {
        return match ($tipo) {
            'usuario' => Usuario::findOrFail($id),
            'empresa' => Empresa::findOrFail($id),
            default => abort(404),
        };
    }

    public function listarTodos()
    {
        return Calificacion::with(['usuario','empresa','usuarioCalificado','empresaCalificada',
            'postulacion.usuario', 'postulacion.oferta.empresa', 'postulacion.oferta.usuario'
        ])->get();
    }

    public function historialDeCuenta(Usuario|Empresa $cuenta)
    {
        $esEmpresa = $cuenta instanceof Empresa;
        $columnaDestino = $esEmpresa ? 'idEmpresaCalificada' : 'idUsuarioCalificado';

        return Calificacion::with([
            'usuario',
            'empresa',
            'usuarioCalificado',
            'empresaCalificada',
            'postulacion.oferta.empresa',
            'postulacion.oferta.usuario',
        ])
            ->whereHas('postulacion', fn ($query) => $query->where('estado', 'Contratado'))
            ->where($columnaDestino, $cuenta->id)
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();
    }

    public function promedioRecibido(Usuario|Empresa $cuenta): array
    {
        $columna = $cuenta instanceof Empresa ? 'idEmpresaCalificada' : 'idUsuarioCalificado';
        $fila = Calificacion::where($columna, $cuenta->id)
            ->selectRaw('AVG(puntuacion) as promedio, COUNT(*) as total')->first();

        return ['promedio' => (float) ($fila->promedio ?? 0), 'total' => (int) ($fila->total ?? 0)];
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
            ->where('tipoCalificador', 'usuario')
            ->exists();
    }

    /** ¿Ya calificó quien publicó esta oferta, sea empresa o usuario? */
    public function yaCalificadaPorPublicador(int $idPostulacion, int $idPublicador, bool $esEmpresa): bool
    {
        return Calificacion::where('idPostulacion', $idPostulacion)
            ->where('tipoCalificador', $esEmpresa ? 'empresa' : 'usuario')
            ->where($esEmpresa ? 'idEmpresa' : 'idUsuario', $idPublicador)
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
