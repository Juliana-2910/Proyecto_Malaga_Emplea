<?php

namespace App\Repositories;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class usuariosRepository{

    public function listarTodos()
    {
        return Usuario::with('rol')->get();
    }

    public function listarUsuarios()
    {
    return Usuario::with('rol')
        ->whereHas('rol', function ($query) {
            $query->where('rol', 'usuario');
        })
        ->get();
    }

    public function guardar(array $datos)
    {
        Usuario::create($datos);
    }

    public function eliminar (int $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
    }

    public function buscarPorId(int $id)
    {
        $usuario = Usuario::findOrFail($id);

        return $usuario;
    }

    public function actualizar(int $id, array $datos)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->update($datos);
    }
    
    // Subconsulta: usuarios que han realizado postulaciones
    public function listarUsuariosConPostulaciones()
    {
        return DB::select("
            SELECT u.id, u.nombres, u.apellidos
            FROM usuarios AS u
            WHERE EXISTS (
                SELECT 1
                FROM postulacion AS p
                WHERE p.idUsuario = u.id
            )
        ");
    }

    
    // Subconsulta: usuarios que no han realizado postulaciones
    public function listarUsuariosSinPostulaciones()
    {
        return DB::select("
            SELECT u.id, u.nombres, u.apellidos
            FROM usuarios AS u
            WHERE NOT EXISTS (
                SELECT 1
                FROM postulacion AS p
                WHERE p.idUsuario = u.id
            )
        ");
    }

}

