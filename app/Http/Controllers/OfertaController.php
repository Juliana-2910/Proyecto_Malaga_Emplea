<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use App\Services\ofertasService;
use App\Http\Requests\OfertaStoreRequest;
use App\Http\Requests\OfertaUpdateRequest;
use App\Services\empresasServices;
use Illuminate\Http\Request;

class OfertaController extends Controller
{

    private ofertasService $ofertasService;
    private empresasServices $empresasServices;

public function __construct(ofertasService $ofertasService, empresasServices $empresasServices)
{
    $this->ofertasService = $ofertasService;
    $this->empresasServices = $empresasServices;
}

    public function index()
    {
         $ofertas = $this->ofertasService->listarTodos();

         return view('Ofertas.index', compact('ofertas'));
    }

    
    public function create()
    {
         $empresas = $this->empresasServices->listarTodos();

         return view('Ofertas.crear', compact('empresas'));
    }

    
    public function store(OfertaStoreRequest $request)
    {
         $this->ofertasService->guardar($request->all());

         return redirect()->route('ofertas.index')
          ->with('success', 'Oferta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Oferta $oferta)
    {
        //
    }

    
    public function edit(int $id)
    {
         $oferta = $this->ofertasService->buscarporid($id);
         $empresas = $this->empresasServices->listarTodos();

        return view('Ofertas.editar', compact('oferta', 'empresas'));
    }

    
    public function update(int $id, OfertaUpdateRequest $request)
    {
          $this->ofertasService->actualizar($id, $request->all());

         return redirect()->route('ofertas.index')
         ->with('actualizar', 'Oferta actualizada exitosamente.');
    }

    
    public function destroy($id)
    {
        $this->ofertasService->eliminar($id);

         return redirect()->route('ofertas.index')
         ->with('eliminar', 'Oferta eliminada exitosamente.');
    }
}
