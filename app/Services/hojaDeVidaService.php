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
        $archivo = $this->extraerArchivo($datos);
        $hojaDeVida = $this->hojaDeVidaRepository->guardar($datos);
        $this->asociarArchivo($archivo, $hojaDeVida->id);
        return $hojaDeVida;
    }

    public function eliminar(int $id)
    {
        $hojaDeVida = $this->hojaDeVidaRepository->buscarPorId($id);
        $this->validarQueNoTengaPostulacionesEnCurso($hojaDeVida->idUsuario);
        $this->hojaDeVidaRepository->eliminar($id);
        $this->eliminarArchivo($hojaDeVida->archivoCV);
    }

    public function buscarPorId(int $id)
    {
        return $this->hojaDeVidaRepository->buscarPorId($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $hojaDeVida = $this->hojaDeVidaRepository->buscarPorId($id);
        $archivoAnterior = $hojaDeVida->archivoCV;
        $archivo = $this->extraerArchivo($datos);

        if (!$archivo) {$this->hojaDeVidaRepository->actualizar($id, $datos);
            return;
        }

        $this->reemplazarArchivo($id, $datos, $archivo,$archivoAnterior);
    }

    private function extraerArchivo(array &$datos): ?UploadedFile
    {
        $archivo = $datos['archivoCV'] ?? null;
        unset($datos['archivoCV']);
        return $archivo instanceof UploadedFile ? $archivo : null;
    }

    private function asociarArchivo(?UploadedFile $archivo, int $id): void
    {
        if (!$archivo) {
            return;
        }

        $ruta = $this->guardarArchivo($archivo, $id);
        $this->hojaDeVidaRepository->actualizar($id, ['archivoCV' => $ruta]);
    }

    private function reemplazarArchivo(int $id, array $datos, UploadedFile $archivo, ?string $archivoAnterior): void
    {
        $rutaNueva = $this->guardarArchivo($archivo, $id);

        try {
            $datos['archivoCV'] = $rutaNueva;
            $this->hojaDeVidaRepository->actualizar($id, $datos);
        } catch (\Throwable $e) {$this->eliminarArchivo($rutaNueva); throw $e;}

        $this->eliminarArchivo($archivoAnterior);
    }

    private function validarHojaDeVidaUnica(int $idUsuario): void
    {
        if ($this->hojaDeVidaRepository->existePorUsuario($idUsuario)) {
            throw new Exception(
                'Este usuario ya tiene una hoja de vida registrada. Puede editar la existente.'
            );
        }
    }

    private function validarQueNoTengaPostulacionesEnCurso(int $idUsuario): void
    {
        if ($this->postulacionRepository->tienePostulacionesEnCurso($idUsuario)){
            throw new Exception(
                'No se puede eliminar la hoja de vida porque el usuario tiene postulaciones en curso.'
            );
        }
    }

    private function guardarArchivo(UploadedFile $archivo, int $id): string
    {
        $nombreOriginal = pathinfo( $archivo->getClientOriginalName(), PATHINFO_FILENAME);
        $nombreSeguro = preg_replace('/[^A-Za-z0-9_-]/', '_',$nombreOriginal);
        $nombreArchivo = $nombreSeguro . '_' . $id . '_' . uniqid() . '.pdf';
        return $archivo->storeAs('hojasDeVida', $nombreArchivo, 'public'
        );
    }

    private function eliminarArchivo(?string $ruta): void
    {
        if ($ruta) {Storage::disk('public')->delete($ruta);}
    }
}
