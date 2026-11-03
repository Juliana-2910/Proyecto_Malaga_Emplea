<?php

namespace App\Services\Seguridad;

use App\Repositories\Seguridad\UsuarioRepository;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private UsuarioRepository $usuarioRepository) {}

    public function autenticar(string $email, string $password, bool $recordar = false, string $tipo = 'usuario'): bool
    {
        $usuario = $this->usuarioRepository->buscarPorEmail($email, $tipo);

        if ($usuario === null || ! Hash::check($password, $usuario->getAuthPassword())) {
            return false;
        }

        $this->verificarCuentaActiva($usuario, $tipo);

        Auth::guard($this->guard($tipo))->login($usuario, $recordar);

        return true;
    }

    public function cerrarSesion(): void
    {
        foreach ($this->guards() as $guard) {
            Auth::guard($guard)->logout();
        }
    }

    private function guard(string $tipo): string
    {
        return config("seguridad.login.$tipo.guard", config('seguridad.guard'));
    }

    private function guards(): array
    {
        $guards = collect(config('seguridad.login') ?? [])->pluck('guard')->unique()->all();

        return $guards === [] ? [config('seguridad.guard')] : $guards;
    }

    private function verificarCuentaActiva(Authenticatable $usuario, string $tipo): void
    {
        $columna = config("seguridad.login.$tipo.columna_estado");

        if ($columna === null) {
            return;
        }

        if ($usuario->{$columna} !== config("seguridad.login.$tipo.valor_activo", 'activo')) {
            throw new Exception('Tu cuenta está inactiva. Comunícate con el administrador.');
        }
    }
}
