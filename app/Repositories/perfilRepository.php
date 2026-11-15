<?php

namespace App\Repositories;

use App\Models\Empresa;
use App\Models\Usuario;

class perfilRepository
{
    // Guarda la nueva contraseña de la cuenta (persona o empresa).
    // No se encripta aquí: Usuario y Empresa tienen 'password' => 'hashed'
    // en casts(), así que Laravel la encripta solo al guardar.
    public function actualizarContrasena(Usuario|Empresa $cuenta, string $nuevaContrasena): void
    {
        $cuenta->update(['password' => $nuevaContrasena]);
    }
}
