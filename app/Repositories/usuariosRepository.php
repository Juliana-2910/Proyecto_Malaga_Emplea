<?php

namespace App\Repositories;

use App\Models\Roles;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class usuariosRepository{

    public function listarTodos()
    {
        return Usuario::with('roles')->get();
    }

    public function listarUsuarios()
    {
        return Usuario::with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'usuario'); // Cambiado 'roles' por 'name'
            })
            ->get();
    }

    public function guardar(array $datos)
    {

    return DB::transaction(function () use ($datos) {

        $usuario = Usuario::create($datos);

        $usuario->assignRole('usuario');

        return $usuario;
    });
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


    if (empty($datos['password'])) {
        unset($datos['password']);
    }

    $usuario->update($datos);

    return $usuario;
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
