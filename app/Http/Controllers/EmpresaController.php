<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Services\empresasServices;
use App\Http\Requests\EmpresaStoreRequest;
use App\Http\Requests\EmpresaUpdateRequest;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
     private empresasServices $empresasServices;

        public function __construct(empresasServices $empresasServices)
        {
            $this->empresasServices = $empresasServices;
        }

    public function index()
    {
        $empresas = $this->empresasServices->listarTodos();
        return view('Empresa.index', compact('empresas'));
    }

    
    public function create()
    {
        return view('Empresa.crear');
    }

    
    public function store(Request $request)
    {
        $this->empresasServices->guardar($request->all());

        return redirect()->route('empresas.index')
        ->with('success', 'Empresa creada exitosamente.');
    }


    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit(int $id)
{
    $empresa = $this->empresasServices->buscarporid($id);

    return view('Empresa.editar', compact('empresa'));
}

    
    public function update(int $id, EmpresaUpdateRequest $request)
    {
         $this->empresasServices->actualizar($id, $request->all());
        return redirect()->route('empresas.index')->with('actualizar', 'Empresa actualizada exitosamente.');
    }

   
    public function destroy($id)
    {
        $this->empresasServices->eliminar($id);
        return redirect()->route('empresas.index')->with('eliminar', 'Empresa eliminada exitosamente.');
    }
}
