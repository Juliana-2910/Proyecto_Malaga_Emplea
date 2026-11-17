<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfertaServiciosStoreRequest;
use App\Http\Requests\OfertaServiciosUpdateRequest;
use App\Models\OfertaServicios;
use App\Services\ofertaServiciosService;
use App\Services\ofertasService;
use App\Services\serviciosService;
use Exception;
use InvalidArgumentException;
use Illuminate\Http\Request;

class OfertaServiciosController extends Controller
{
    private ofertaServiciosService $ofertaServiciosService;
    private serviciosService $serviciosService;
    private ofertasService $ofertasService;

    public function __construct(
        ofertaServiciosService $ofertaServiciosService,
        serviciosService $serviciosService,
        ofertasService $ofertasService
    )

    {
        $this->ofertaServiciosService = $ofertaServiciosService;
        $this->serviciosService = $serviciosService;
        $this->ofertasService = $ofertasService;
    }

    public function index(Request $request)
    {
        try {
            $ofertaServicios = $this->ofertaServiciosService->listarPaginado($request->only('buscar'));

            return view('OfertaServicios.index', compact('ofertaServicios'));
        } catch (InvalidArgumentException $e) {
            return redirect()->route('ofertaServicios.index')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $servicios = $this->serviciosService->listarTodos();
        $ofertas = $this->ofertasService->listarTodos();
        return view('OfertaServicios.crear', compact('servicios', 'ofertas'));

    }

    public function store(OfertaServiciosStoreRequest $request)
    {
        $this->ofertaServiciosService->guardar($request->all());
        return redirect()->route('ofertaServicios.index')->with('success','Oferta Servicio creada exitosamente');
    }

    public function show(OfertaServicios $ofertaServicios)
    {
        //
    }

    public function edit(int $id)
    {
        $ofertaServicios = $this->ofertaServiciosService->buscarporId($id);
        $servicios = $this->serviciosService->listarTodos();
        $ofertas = $this->ofertasService->listarTodos();
        return view('OfertaServicios.editar', compact('ofertaServicios', 'servicios','ofertas'));
    }

    public function update(int $id, OfertaServiciosUpdateRequest $request)
    {
        $this->ofertaServiciosService->actualizar($id, $request->all());
        return redirect()->route('ofertaServicios.index')->with('actualizar','Oferta Servicio actualizda exitosamente');
    }

    public function destroy($id)
    {
        try {
            $this->ofertaServiciosService->eliminar((int) $id);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('ofertaServicios.index')->with('eliminar', 'Oferta Servicio eliminada exitosamente');
    }
}
