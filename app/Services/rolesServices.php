<?php

namespace App\Services;


use App\Repositories\rolesRepository; /*Toca colocarlo manualmente*/

class rolesServices{

   private rolesRepository $rolesrepository;

   public function __construct(rolesRepository $rolesrepository)
   {
       $this->rolesrepository = $rolesrepository;
   }

    public function listarTodos()
    {
        return $this->rolesrepository->listarTodos();
    }

    public function guardar(array $datos)
    {
        $this->rolesrepository->guardar($datos);
    }

    public function eliminar(int $id)
    {
        $this->rolesrepository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
        return $this->rolesrepository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos)
    {
        $this->rolesrepository->actualizar($id, $datos);
    }

}