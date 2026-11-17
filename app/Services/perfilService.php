<?php

namespace App\Services;

use App\Models\Empresa;
use App\Models\Usuario;
use App\Repositories\perfilRepository;
use Exception;
use Illuminate\Support\Facades\Hash;

class perfilService
{
    private perfilRepository $perfilRepository;
    private usuariosService $usuariosService;
    private empresasServices $empresasServices;
    private hojaDeVidaService $hojaDeVidaService;

    public function __construct(
        perfilRepository $perfilRepository,
        usuariosService $usuariosService,
        empresasServices $empresasServices,
        hojaDeVidaService $hojaDeVidaService
    ) {
        $this->perfilRepository = $perfilRepository;
        $this->usuariosService = $usuariosService;
        $this->empresasServices = $empresasServices;
        $this->hojaDeVidaService = $hojaDeVidaService;
    }

    // Lo que necesita la pantalla "Editar perfil".
    public function datosParaEditar(Usuario|Empresa $cuenta): array
    {
        $esEmpresa = $cuenta instanceof Empresa;
        $hojaDeVida = $esEmpresa ? null : $this->hojaDeVidaService->buscarPorUsuario($cuenta->id);

        return compact('cuenta', 'esEmpresa', 'hojaDeVida');
    }

    // Guarda los datos del perfil reutilizando los services que ya existen.
    public function actualizarPerfil(Usuario|Empresa $cuenta, array $datos): void
    {
        // El documento no se edita nunca, aunque alguien intente enviarlo.
        unset($datos['tipoDocumento'], $datos['numeroDocumento']);

        if ($cuenta instanceof Empresa) {
            $this->empresasServices->actualizar($cuenta->id, $datos);
            return;
        }

        $this->usuariosService->actualizar($cuenta->id, $datos);
    }

    public function cambiarContrasena(Usuario|Empresa $cuenta, string $actual, string $nueva): void
    {
        $this->validarContrasenaActual($cuenta, $actual);
        $this->validarContrasenaNueva($actual, $nueva);

        $this->perfilRepository->actualizarContrasena($cuenta, $nueva);
    }

    private function validarContrasenaActual(Usuario|Empresa $cuenta, string $actual): void
    {
        if (! Hash::check($actual, $cuenta->password)) {
            throw new Exception('La contraseña actual no es correcta.');
        }
    }

    private function validarContrasenaNueva(string $actual, string $nueva): void
    {
        if ($actual === $nueva) {
            throw new Exception('La nueva contraseña debe ser diferente a la actual.');
        }
    }
}
