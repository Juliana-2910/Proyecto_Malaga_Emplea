<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use App\Services\serviciosService;
use App\Services\categoriasService;
use App\Http\Requests\ServiciosStoreRequest;
use App\Http\Requests\ServiciosUpdateRequest;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    private serviciosService $serviciosService;
    private categoriasService $categoriaService;

    public function __construct(serviciosService $serviciosService, categoriasService $categoriaService)
    {
        $this->serviciosService = $serviciosService;
        $this->categoriaService = $categoriaService;
    }

    public function index()
    {
        $servicios = $this->serviciosService->listarTodos();
        return view('Servicios.index', compact('servicios'));
    }

    public function create()
    {
        $categorias = $this->categoriaService->listarTodos()->unique('nombre');
        return view('Servicios.crear', compact('categorias'));
    }

    public function store(ServiciosStoreRequest $request)
    {
        $this->serviciosService->guardar($request->validated());
        return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function show(Servicios $servicios)
    {
        //
    }

    public function edit(int $id)
    {
        $servicios = $this->serviciosService->buscarPorId($id);
        $categorias = $this->categoriaService->listarTodos()->unique('nombre');
        return view('Servicios.editar', compact('servicios', 'categorias'));
    }

    public function update(int $id, ServiciosUpdateRequest $request)
    {
        $this->serviciosService->actualizar($id, $request->validated());
        return redirect()->route('servicios.index')->with('actualizar', 'Servicio actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $this->serviciosService->eliminar($id);
        return redirect()->route('servicios.index')->with('eliminar', 'Servicio eliminado exitosamente.');
    }
}
