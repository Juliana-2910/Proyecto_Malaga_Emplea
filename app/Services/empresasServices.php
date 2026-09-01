<?php

namespace App\Services;


use App\Repositories\empresasRepository; /*Toca colocarlo manualmente*/

class empresasServices{

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
        $this->empresasrepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->empresasrepository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
        return $this->empresasrepository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $this->empresasrepository->actualizar($id, $datos);
    }

}