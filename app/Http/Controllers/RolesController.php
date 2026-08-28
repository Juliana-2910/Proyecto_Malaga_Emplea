<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Services\rolesServices;
use App\Http\Requests\RolesStoreRequest;
use App\Http\Requests\RolesUpdateRequest;
use Illuminate\Http\Request;

class RolesController extends Controller
{
        private rolesServices $rolesServices;

        public function __construct(rolesServices $rolesServices)
        {
            $this->rolesServices = $rolesServices;
        }

    public function index()
    {
        $roles = $this->rolesServices->listarTodos();
        return view('Roles.index', compact('roles'));
    }

  
    public function create()
    {
        return view('Roles.crear');
    }

    public function store(RolesStoreRequest $request)
    {
       
        $this->rolesServices->guardar($request->all());

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
        
    }

   
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $roles = $this->rolesServices->buscarporid($id);
        return view('Roles.editar', compact('roles'));
    }

   
    public function update(int $id, RolesUpdateRequest $request)
    {
        $this->rolesServices->actualizar($id, $request->all());
        return redirect()->route('roles.index')->with('actualizar', 'Rol actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $this->rolesServices->eliminar($id);
        return redirect()->route('roles.index')->with('eliminar', 'Rol eliminado exitosamente.');
    }
}
