<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalificacionStoreRequest;
use App\Http\Requests\CalificacionUpdateRequest;
use App\Models\Calificacion;
use App\Services\calificacionService;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    private calificacionService $calificacionService;

    public function __construct(calificacionService $calificacionService)
    {
        $this->calificacionService = $calificacionService;
    }

    public function index()
    {
        $calificacion = $this->calificacionService->listarTodos();
        return view('Calificacion.index', compact('calificacion'));
    }

    public function create()
    {
        $postulaciones = $this->calificacionService->listarPostulacionesContratadas();

        return view('Calificacion.crear', compact('postulaciones'));
    }

    public function store(CalificacionStoreRequest $request)
    {
        try {
            $datos = $request->validated();
            $this->calificacionService->guardar($datos);
            return redirect()->route('calificacion.index')->with('success', 'Calificación creada correctamente');
        } catch (\Exception $e) {
            return redirect()->back() ->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Calificacion $calificacion)
    {
        //
    }

    public function edit(int $id)
    {
        $calificacion = $this->calificacionService->buscarPorId($id);
        $postulaciones = $this->calificacionService->listarPostulacionesContratadas();

        return view('Calificacion.editar', compact('calificacion', 'postulaciones'));
    }

    public function update(CalificacionUpdateRequest $request, int $id)
    {
        try{
            $datos = $request->validated();
            $this->calificacionService->actualizar($id, $datos);
            return redirect()->route('calificacion.index')->with('actualizar', 'Calificación actualizada correctamente');
        } catch (\Exception $e){
            return redirect()->back() ->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        $this->calificacionService->eliminar($id);
        return redirect()->route('calificacion.index')->with('eliminar','Calificacion eliminada correctamente');
    }

    public function reputacionEmpresas()
    {
        $empresas = $this->calificacionService->listarReputacionEmpresas();
        return response()->json($empresas);
    }

    public function reputacionUsuarios()
    {
        $usuarios = $this->calificacionService->listarReputacionUsuarios();
        return response()->json($usuarios);
    }
}
