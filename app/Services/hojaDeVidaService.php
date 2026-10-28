<?php

namespace App\Services;

use App\Repositories\hojaDeVidaRepository;
use App\Repositories\postulacionRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class hojaDeVidaService
{
    private hojaDeVidaRepository $hojaDeVidaRepository;
    private postulacionRepository $postulacionRepository;

    public function __construct(hojaDeVidaRepository $hojaDeVidaRepository, postulacionRepository $postulacionRepository)
    {
        $this->hojaDeVidaRepository = $hojaDeVidaRepository;
        $this->postulacionRepository = $postulacionRepository;
    }

    public function listarTodos()
    {
        return $this->hojaDeVidaRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $this->validarHojaDeVidaUnica((int) $datos['idUsuario']);

        $archivo = $datos['archivoCV'] ?? null;

        unset($datos['archivoCV']);

        $hojaDeVida = $this->hojaDeVidaRepository->guardar($datos);

        if ($archivo instanceof UploadedFile) {
            $ruta = $this->guardarArchivo($archivo, $hojaDeVida->id);

            $this->hojaDeVidaRepository->actualizar(
                $hojaDeVida->id,
                ['archivoCV' => $ruta]
            );
        }

        return $hojaDeVida;
    }

    public function eliminar(int $id)
    {
        $hojaDeVida = $this->hojaDeVidaRepository->buscarPorId($id);

        if (
            $this->postulacionRepository->tienePostulacionesEnCurso(
                $hojaDeVida->idUsuario
            )
        ) {
            throw new Exception(
                'No se puede eliminar la hoja de vida porque el usuario tiene postulaciones en curso.'
            );
        }

        $this->hojaDeVidaRepository->eliminar($id);

        if ($hojaDeVida->archivoCV) {
            Storage::disk('public')->delete($hojaDeVida->archivoCV);
        }
    }

    public function buscarPorId(int $id)
    {
        return $this->hojaDeVidaRepository->buscarPorId($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $hojaDeVida = $this->hojaDeVidaRepository->buscarPorId($id);
        $archivoAnterior = $hojaDeVida->archivoCV;
        $archivo = $datos['archivoCV'] ?? null;

        unset($datos['archivoCV']);

        if (!($archivo instanceof UploadedFile)) {
            $this->hojaDeVidaRepository->actualizar($id, $datos);
            return;
        }

        $rutaNueva = $this->guardarArchivo($archivo, $id);

        try {
            $datos['archivoCV'] = $rutaNueva;

            $this->hojaDeVidaRepository->actualizar($id, $datos);
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($rutaNueva);
            throw $e;
        }

        if ($archivoAnterior) {
            Storage::disk('public')->delete($archivoAnterior);
        }
    }

    private function guardarArchivo(UploadedFile $archivo, int $id): string
    {
        $nombreOriginal = pathinfo(
            $archivo->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $nombreSeguro = preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $nombreOriginal
        );

        $nombreArchivo = $nombreSeguro . '_' . $id . '_' .
            uniqid() . '.pdf';

        $ruta = $archivo->storeAs(
            'hojasDeVida',
            $nombreArchivo,
            'public'
        );

        return $ruta;
    }

    private function validarHojaDeVidaUnica(int $idUsuario): void
    {
        if ($this->hojaDeVidaRepository->existePorUsuario($idUsuario)) {
            throw new Exception(
                'Este usuario ya tiene una hoja de vida registrada. Puede editar la existente.'
            );
        }
    }
}
