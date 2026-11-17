<?php

namespace App\Services\Seguridad;

use App\Services\usuariosService;
use App\Services\empresasServices;

class RegistroService
{
    public function __construct(
        private usuariosService $usuariosService,
        private empresasServices $empresasServices,
        private AuthService $authService
    ) {}

    public function registrarUsuario(array $datos): bool
    {
        unset($datos['terminos'], $datos['datos']);

        $this->usuariosService->guardar($datos);

        return $this->authService->autenticar(
            $datos['email'],
            $datos['password'],
            false,
            'usuario'
        );
    }

    public function registrarEmpresa(array $datos): bool
    {
        unset($datos['terminos'], $datos['datos']);

        $datos['estado'] = 'activo';

        $this->empresasServices->guardar($datos);

        return $this->authService->autenticar(
            $datos['email'],
            $datos['password'],
            false,
            'empresa'
        );
    }
}
