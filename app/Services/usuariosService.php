<?php

namespace App\Services;

use App\Repositories\usuariosRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class usuariosService{

    private usuariosRepository $usuariosRepository;
    private hojaDeVidaService $hojaDeVidaService;

    public function __construct(
        usuariosRepository $usuariosRepository,
        hojaDeVidaService $hojaDeVidaService
    ) {
        $this->usuariosRepository = $usuariosRepository;
        $this->hojaDeVidaService = $hojaDeVidaService;
    }

    public function listarTodos()
    {
        return $this->usuariosRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $fechaNacimiento = Carbon::parse($datos['fechaNacimiento']); // Validar que el usuario sea mayor de edad
        if ($fechaNacimiento->age < 18) {
            throw ValidationException::withMessages([
                'fechaNacimiento' => 'El usuario debe tener mínimo 18 años para registrarse.'
            ]);
        }
        if (isset($datos['fotoPerfil'])) {
            $foto = $datos['fotoPerfil'];
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $ruta = $foto->storeAs(
                'usuarios/fotos',
                $nombreFoto,
                'public'
            ); // Guardar foto de perfil
            $datos['fotoPerfil'] = $ruta;
        }
        $this->usuariosRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $usuario = $this->usuariosRepository->buscarPorId($id); // Buscar el usuario
        if ($usuario->fotoPerfil) {
            Storage::disk('public')->delete(
                $usuario->fotoPerfil
            );  // Eliminar foto de perfil
        }
        $hojasDeVida = $usuario->hojaDeVida; // Obtener hojas de vida asociadas
        foreach ($hojasDeVida as $hoja) {
            $this->hojaDeVidaService->eliminar($hoja->id); // Eliminar cada hoja de vida
        }
        $this->usuariosRepository->eliminar($id); // Finalmente eliminar el usuario
    }

    public function buscarPorId(int $id)
    {
        return $this->usuariosRepository->buscarPorId($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $usuario = $this->usuariosRepository->buscarPorId($id); // Buscar el usuario
        $fechaNacimiento = Carbon::parse($datos['fechaNacimiento']); // Validar que el usuario sea mayor de edad
        if ($fechaNacimiento->age < 18) {
        throw ValidationException::withMessages([
            'fechaNacimiento' => 'El usuario debe tener mínimo 18 años para actualizar sus datos.'
        ]);
    }
        if (isset($datos['fotoPerfil'])) {
            $foto = $datos['fotoPerfil'];
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $ruta = $foto->storeAs(
                'usuarios/fotos',
                $nombreFoto,
                'public'
            );
            if ($usuario->fotoPerfil) {
                Storage::disk('public')->delete(
                    $usuario->fotoPerfil
                ); // Eliminar foto anterior
            }
            $datos['fotoPerfil'] = $ruta;
        }
        $this->usuariosRepository->actualizar($id, $datos);
    }
}

