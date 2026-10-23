<?php

namespace App\Services;

use App\Repositories\ofertasRepository;
use Carbon\Carbon;

class ofertasService
{
    private ofertasRepository $ofertasrepository;

    public function __construct(ofertasRepository $ofertasrepository)
    {
        $this->ofertasrepository = $ofertasrepository;
    }

    public function listarTodos()
    {
        return $this->ofertasrepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $datos['fechaPublicacion'] = Carbon::now('America/Bogota')->toDateString();

        $this->ofertasrepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->ofertasrepository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
        return $this->ofertasrepository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos)
    {
        unset($datos['fechaPublicacion']);

        $this->ofertasrepository->actualizar($id, $datos);
    }
}
