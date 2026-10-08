<?php

namespace App\Services;

use App\Repositories\hojaDeVidaRepository;
use Illuminate\Support\Facades\Storage;

class hojaDeVidaService
{
    private hojaDeVidaRepository $hojaDeVidaRepository;

    public function __construct(hojaDeVidaRepository $hojaDeVidaRepository)
    {
        $this->hojaDeVidaRepository = $hojaDeVidaRepository;
    }

    public function listarTodos()
    {
        return $this->hojaDeVidaRepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        if (isset($datos['archivoCV'])) {
            $archivo = $datos['archivoCV'];
            $datos['archivoCV'] = 'pendiente'; // Guardamos temporalmente un valor para poder crear el registro
            $hojaDeVida = $this->hojaDeVidaRepository->guardar($datos); // Crear la hoja de vida y obtener su ID
            $nombreOriginal = pathinfo(
                $archivo->getClientOriginalName(),
                PATHINFO_FILENAME
            ); // Obtener nombre original del archivo
            $extension = $archivo->getClientOriginalExtension(); // Obtener extensión
            $nombreArchivo = $nombreOriginal . '_' . $hojaDeVida->id . '.' . $extension; // Crear nombre único con ID
            $ruta = $archivo->storeAs(
                'hojasDeVida',
                $nombreArchivo,
                'public'
            ); // Guardar el archivo
            $this->hojaDeVidaRepository->actualizar(
                $hojaDeVida->id,
                [
                    'archivoCV' => $ruta
                ]
            ); // Actualizamos la ruta del archivo en la base de datos

            return;
        }

        $this->hojaDeVidaRepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $hojaDeVida = $this->hojaDeVidaRepository->buscarPorId($id); // Obtener la hoja de vida antes de eliminarla
        if ($hojaDeVida->archivoCV) {

            Storage::disk('public')->delete(
                $hojaDeVida->archivoCV
            );
        } // Eliminar archivo del storage si existe
        $this->hojaDeVidaRepository->eliminar($id); // Eliminar registro de la base de datos
    }

    public function buscarPorId(int $id)
    {
        return $this->hojaDeVidaRepository->buscarPorId($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $hojaDeVida = $this->hojaDeVidaRepository->buscarPorId($id); // Buscar hoja de vida actual
        if (isset($datos['archivoCV'])) {
            $archivo = $datos['archivoCV'];
            if ($hojaDeVida->archivoCV) {
                Storage::disk('public')->delete(
                    $hojaDeVida->archivoCV
                ); // Eliminar archivo anterior
            }
            $nombreOriginal = pathinfo(
                $archivo->getClientOriginalName(),
                PATHINFO_FILENAME
            ); // Obtener nombre original
            $extension = $archivo->getClientOriginalExtension(); // Obtener extensión
            $nombreArchivo = $nombreOriginal . '_' . $hojaDeVida->id . '.' . $extension; // Crear nombre: nombreOriginal_ID.extension
            $ruta = $archivo->storeAs(
                'hojasDeVida',
                $nombreArchivo,
                'public'
            ); // Guardar nuevo archivo
            $datos['archivoCV'] = $ruta; // Guardar la ruta en los datos
        }
        $this->hojaDeVidaRepository->actualizar($id, $datos); // Actualizar la hoja de vida
    }
}
