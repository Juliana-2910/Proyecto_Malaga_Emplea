<?php

namespace App\Http\Controllers;

use App\Models\HojaDeVida;
use App\Services\hojaDeVidaService;
use App\Services\usuariosService;
use App\Http\Requests\HojaDeVidaStoreRequest;
use App\Http\Requests\HojaDeVidaUpdateRequest;
use Illuminate\Http\Request;

class HojaDeVidaController extends Controller
{
    private hojaDeVidaService $hojaDeVidaService;
    private usuariosService $usuariosService;

    public function __construct(hojaDeVidaService $hojaDeVidaService, usuariosService $usuariosService)
    {
        $this->hojaDeVidaService = $hojaDeVidaService;
        $this->usuariosService = $usuariosService;
    }

    public function index()
    {
        $hojaDeVida = $this->hojaDeVidaService->listarTodos();
        return view('HojaDeVida.index', compact('hojaDeVida'));
    }

    public function create()
    {
        $usuarios = $this->usuariosService->listarTodos();
        return view('HojaDeVida.crear', compact('usuarios'));
    }

    public function store(HojaDeVidaStoreRequest $request)
    {
        $this->hojaDeVidaService->guardar($request->validated());
        return redirect()->route('HojaDeVida.index')->with('success', 'Hoja de vida creada exitosamente.');
    }

    public function show(HojaDeVida $hojaDeVida)
    {
        //
    }

    public function edit(int $id)
    {
        $hojaDeVida = $this->hojaDeVidaService->buscarPorId($id);
        $usuarios = $this->usuariosService->listarTodos();
        return view('HojaDeVida.editar', compact('hojaDeVida', 'usuarios'));
    }

    public function update(int $id, HojaDeVidaUpdateRequest $request)
    {
        $this->hojaDeVidaService->actualizar($id, $request->validated());
        return redirect()->route('HojaDeVida.index')->with('success', 'Hoja de vida actualizada exitosamente.');
    }

    public function destroy(int $id)
    {
        $this->hojaDeVidaService->eliminar($id);
        return redirect()->route('HojaDeVida.index')->with('success', 'Hoja de vida eliminada exitosamente.');
    }
}
