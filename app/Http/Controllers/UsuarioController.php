<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\usuariosService;
use App\Http\Requests\UsuariosStoreRequest;
use App\Http\Requests\UsuariosUpdateRequest;

class UsuarioController extends Controller
{
    private usuariosService $usuariosService;
    public function __construct(usuariosService $usuariosService)
    {
        $this->usuariosService = $usuariosService;
    }

    public function index()
    {
        $usuarios = $this->usuariosService->listarTodos();
        return view('Usuarios.index', compact('usuarios'));
    }


    public function usuariosConPostulaciones()
    {
        $usuarios = $this->usuariosService->listarUsuariosConPostulaciones();

        return response()->json($usuarios);
    }

    public function usuariosSinPostulaciones()
    {
        $usuarios = $this->usuariosService->listarUsuariosSinPostulaciones();

        return response()->json($usuarios);
    }

    public function create()
    {
        return view('Usuarios.crear');
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

        return view('Usuarios.editar', compact('usuarios'));
    }

    public function update(int $id,UsuariosUpdateRequest $request)
    {
        $this->usuariosService->actualizar($id, $request->validated());
        return redirect()->route('usuarios.index')->with('actualizar', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $this->usuariosService->eliminar($id);
        return redirect()->route('usuarios.index')->with('eliminar', 'Usuario eliminado exitosamente.');
    }
}
