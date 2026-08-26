<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Services\categoriasService;
use App\Http\Requests\CategoriasStoreRequest;
use App\Http\Requests\CategoriasUpdateRequest;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    private categoriasService $categoriasService;

    public function __construct(categoriasService $categoriasService)
    {
        $this->categoriasService = $categoriasService;
    }

    public function index()
    {
        $categorias = $this->categoriasService->listarTodos();
        return view('Categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('Categorias.crear');
    }


    public function store(CategoriasStoreRequest $request)
    {
        $this->categoriasService->guardar($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }


    public function show(Categoria $categoria)
    {
        //
    }


    public function edit(int $id)
    {
        $categoria = $this->categoriasService->buscarPorId($id);
        return view('Categorias.editar', compact('categoria'));
    }


    public function update(int $id, CategoriasUpdateRequest $request)
    {
        $this->categoriasService->actualizar($id, $request->all());
        return redirect()->route('categorias.index')->with('actualizar', 'Categoría actualizada exitosamente.');
    }


        public function destroy($id)
    {
        $this->categoriasService->eliminar($id);
        return redirect()->route('categorias.index')->with('eliminar', 'Categoría eliminada exitosamente.');
    }
}

