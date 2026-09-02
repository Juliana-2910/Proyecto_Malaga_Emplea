<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Services\usuariosService;
use App\Services\rolesServices;
use App\Http\Requests\UsuariosStoreRequest;
use App\Http\Requests\UsuariosUpdateRequest;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private usuariosService $usuariosService;
    private rolesServices $rolesService;

    public function __construct(usuariosService $usuariosService, rolesServices $rolesService)
    {
        $this->usuariosService = $usuariosService;
        $this->rolesService = $rolesService;
    }

    public function index()
    {
        $usuarios = $this->usuariosService->listarTodos();

        return view('Usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = $this->rolesService->listarTodos()->unique('rol');
        return view('Usuarios.crear', compact('roles'));
    }

    public function store(UsuariosStoreRequest $request)
    {
        $this->usuariosService->guardar($request->validated());
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function show(Usuario $usuario)
    {
        //
    }

    public function edit(int $id)
    {
        $usuarios = $this->usuariosService->buscarPorId($id);
        $roles = $this->rolesService->listarTodos()->unique('rol');
        return view('Usuarios.editar', compact('usuarios', 'roles'));
    }

    public function update(int $id,UsuariosUpdateRequest $request)
    {
        $this->usuariosService->actualizar($id, $request->validated());
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $this->usuariosService->eliminar($id);
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
