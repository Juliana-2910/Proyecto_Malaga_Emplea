<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use App\Services\ofertasService;
use App\Services\usuariosService;
use App\Http\Requests\OfertaStoreRequest;
use App\Http\Requests\OfertaUpdateRequest;
use App\Services\empresasServices;
use Illuminate\Http\Request;

class OfertaController extends Controller
{
    private usuariosService $usuariosService;
    private ofertasService $ofertasService;
    private empresasServices $empresasServices;

    public function __construct(ofertasService $ofertasService, empresasServices $empresasServices, usuariosService $usuariosService)
    {
        $this->ofertasService = $ofertasService;
        $this->empresasServices = $empresasServices;
        $this->usuariosService = $usuariosService;
    }

    public function index()
    {
        $ofertas = $this->ofertasService->listarTodos();
        return view('Ofertas.index', compact('ofertas'));
    }


    public function create()
    {
        $empresas = $this->empresasServices->listarTodos();
        $usuarios = $this->usuariosService->listarUsuarios();

        return view('Ofertas.crear', compact('empresas', 'usuarios'));
    }


    public function store(OfertaStoreRequest $request)
    {
        try {
            $this->ofertasService->guardar($request->validated());

            return redirect()->route('ofertas.index')->with('success', 'Oferta creada exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function show(Oferta $oferta)
    {
        //
    }

    public function edit(int $id)
    {
        $oferta = $this->ofertasService->buscarporid($id);
        $empresas = $this->empresasServices->listarTodos();
        $usuarios = $this->usuariosService->listarUsuarios();

        return view('Ofertas.editar', compact('oferta', 'empresas', 'usuarios'));
    }



    public function update(int $id, OfertaUpdateRequest $request)
    {
        try {
            $this->ofertasService->actualizar($id, $request->validated());

            return redirect()->route('ofertas.index')->with('actualizar', 'Oferta actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->ofertasService->eliminar($id);

            return redirect()->route('ofertas.index')->with('eliminar', 'Oferta eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('ofertas.index')->with('error', $e->getMessage());
        }
    }

    public function ofertasSobrePromedioPostulaciones()
    {
        $ofertas = $this->ofertasService->listarOfertasSobrePromedioPostulaciones();

        return response()->json($ofertas);
    }

    public function ofertasConServicios()
    {
        $ofertas = $this->ofertasService->listarOfertasConServicios();

        return response()->json($ofertas);
    }

    public function ofertasSinServicios()
    {
        $ofertas = $this->ofertasService->listarOfertasSinServicios();

        return response()->json($ofertas);
    }
}
