<?php

namespace App\Http\Controllers;

use App\Models\Postulacion;
use Illuminate\Http\Request;
use App\Services\postulacionService;
use App\Services\usuariosService;
use App\Services\ofertasService;
use App\Http\Requests\PostulacionStoreRequest;
use App\Http\Requests\PostulacionUpdateRequest;

class PostulacionController extends Controller
{
    private postulacionService $postulacionService;
    private usuariosService $usuariosService;
    private ofertasService $ofertasService;

    public function __construct(
        postulacionService $postulacionService,
        usuariosService $usuariosService,
        ofertasService $ofertasService
    )

    {
        $this->postulacionService = $postulacionService;
        $this->usuariosService = $usuariosService;
        $this->ofertasService = $ofertasService;
    }

    public function index()
    {
        $postulaciones = $this->postulacionService->listarTodos();
        return view('Postulacion.index', compact('postulaciones'));
    }


    public function create()
    {
        $usuarios = $this->usuariosService->listarTodos();
        $ofertas = $this->ofertasService->listarTodos();
        return view('Postulacion.crear', compact('usuarios', 'ofertas'));
    }


    public function store(PostulacionStoreRequest $request)
    {
        $this->postulacionService->guardar($request->all());
        return redirect()->route('postulacion.index')->with('success', 'Postulación creada exitosamente.');
    }

    public function show(Postulacion $postulacion)
    {
        //
    }

    public function edit(int $id)
    {
        $postulacion = $this->postulacionService->buscarporid($id);
        $usuarios = $this->usuariosService->listarTodos();
        $ofertas = $this->ofertasService->listarTodos();
        return view('Postulacion.editar', compact('postulacion', 'usuarios', 'ofertas'));
    }


    public function update(int $id, PostulacionUpdateRequest $request)
    {
        $this->postulacionService->actualizar($id, $request->all());

        return redirect()->route('postulacion.index')->with('actualizar', 'Postulación actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $this->postulacionService->eliminar($id);
        return redirect()->route('postulacion.index')->with('eliminar', 'Postulación eliminada exitosamente.');
    }
}
