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

    public function guardar(array $datos)
    {
        if (isset($datos['fotoPerfil'])) {
            $datos['fotoPerfil'] = $this->guardarFoto($datos['fotoPerfil']);
        }
        $this->empresasrepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $empresa = $this->empresasrepository->buscarporid($id);
        if ($empresa->fotoPerfil) {
            Storage::disk('public')->delete('empresas/' . $empresa->fotoPerfil);
        }
        $this->empresasrepository->eliminar($id);
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
        $this->empresasrepository->actualizar($id, $datos);
    }

    private function guardarFoto($foto)
    {
        if (!$foto) {
            throw new Exception('No se recibió ninguna foto.');
        }
        $nombreFoto = time() . '_' . $foto->getClientOriginalName();
        $foto->storeAs('empresas', $nombreFoto, 'public');
        return $nombreFoto;
    }
}
