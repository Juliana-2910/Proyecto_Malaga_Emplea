<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\usuariosService;
use App\Http\Requests\UsuariosStoreRequest;
use App\Http\Requests\UsuariosUpdateRequest;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use InvalidArgumentException;

class UsuarioController extends Controller
{
    private usuariosService $usuariosService;
    public function __construct(usuariosService $usuariosService)
    {
        $this->usuariosService = $usuariosService;
    }

    public function index(Request $request)
    {
        try {
            $usuarios = $this->usuariosService->listarPaginado($request->only('buscar'));

            return view('Usuarios.index', compact('usuarios'));
        } catch (InvalidArgumentException $e) {
            return redirect()->route('usuarios.index')->with('error', $e->getMessage());
        }
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
        try {
            $this->usuariosService->eliminar((int) $id);
        } catch (QueryException $e) {
            return back()->with('error', 'No se puede eliminar el usuario porque tiene información relacionada (ofertas, postulaciones o calificaciones).');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('usuarios.index')->with('eliminar', 'Usuario eliminado exitosamente.');
    }
}
