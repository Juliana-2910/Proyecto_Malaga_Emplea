<?php

namespace App\Services;

use App\Repositories\empresasRepository;
use Illuminate\Support\Facades\Storage;
use Exception;

class empresasServices
{
    private empresasRepository $empresasrepository;

    public function __construct(empresasRepository $empresasrepository)
    {
        $this->empresasrepository = $empresasrepository;
    }

    public function listarTodos()
    {
        return $this->empresasrepository->listarTodos();
    }

    public function listarEmpresasConOfertas()
    {
        return $this->empresasrepository->listarEmpresasConOfertas();
    }

    public function guardar(array $datos)
    {
        if (isset($datos['fotoPerfil'])) {
            $datos['fotoPerfil'] = $this->guardarFoto($datos['fotoPerfil']);
        }

        return $this->empresasrepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $empresa = $this->empresasrepository->buscarporid($id);

        $resultado = $this->empresasrepository->eliminar($id);

        if ($resultado && $empresa->fotoPerfil) {
            Storage::disk('public')->delete('empresas/' . $empresa->fotoPerfil);
        }

        return $resultado;
    }

    public function buscarporid(int $id)
    {
        return $this->empresasrepository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $empresa = $this->empresasrepository->buscarporid($id);

        if (isset($datos['fotoPerfil'])) {
            $nuevaFoto = $this->guardarFoto($datos['fotoPerfil']); // Guardar la nueva foto
            if ($empresa->fotoPerfil) {
                Storage::disk('public')->delete('empresas/' . $empresa->fotoPerfil); // Eliminar la foto anterior
            }
            $datos['fotoPerfil'] = $nuevaFoto;
        }
        return $this->empresasrepository->actualizar($id, $datos);
    }

    private function guardarFoto($foto)
    {
        if (!$foto) {
            throw new Exception('No se recibió ninguna foto.');
        }
        $nombreFoto = $foto->hashName();
        $foto->storeAs('empresas', $nombreFoto, 'public');
        return $nombreFoto;
    }
}
