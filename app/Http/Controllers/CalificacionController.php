<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalificacionStoreRequest;
use App\Http\Requests\CalificacionUpdateRequest;
use App\Models\Calificacion;
use App\Services\calificacionService;
use App\Services\empresasServices;
use App\Services\usuariosService;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    private calificacionService $calificacionService;
    private usuariosService $usuariosService;
    private empresasServices $empresasService;

    public function __construct(
        calificacionService $calificacionService,
        usuariosService $usuariosService,
        empresasServices $empresasService)
    {
        $this->calificacionService = $calificacionService;
        $this->usuariosService = $usuariosService;
        $this->empresasService = $empresasService;
    }

    public function index()
    {
        $calificacion = $this->calificacionService->listarTodos();
        return view('Calificacion.index', compact('calificacion'));
    }

    public function create()
    {
        $usuarios = $this->usuariosService->listarTodos();
        $empresas = $this->empresasService->listarTodos();
        return view ('Calificacion.crear', compact ('usuarios','empresas'));
    }

    public function store( CalificacionStoreRequest $request)
    {
        $datos = $request->validated();
        $datos['fecha'] = now('America/Bogota')->toDateString();
        $this->calificacionService->guardar($datos);
        return redirect()->route('calificacion.index')->with('success','Calificacion creada correctamente');
    }

    public function show(Calificacion $calificacion)
    {
        //
    }

    public function edit(int $id)
    {
        $calificacion = $this->calificacionService->buscarPorId($id);
        $usuarios = $this->usuariosService->listarTodos();
        $empresas = $this->empresasService->listarTodos();
        return view('Calificacion.editar',compact('calificacion','usuarios','empresas'));
    }

    public function update(CalificacionUpdateRequest $request, int $id)
    {
        $datos = $request->validated();
        $this->calificacionService->actualizar($id, $datos);
        return redirect()->route('calificacion.index')->with('success','Calificacion actualizada correctamente');
    }

    public function destroy(int $id)
    {
        $this->calificacionService->eliminar($id);
        return redirect()->route('calificacion.index')->with('success','Calificacion eliminada correctamente');
    }
}
