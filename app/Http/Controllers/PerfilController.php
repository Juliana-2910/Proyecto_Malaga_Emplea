<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Usuario;
use App\Services\calificacionService;
use App\Services\empresasServices;
use App\Services\usuariosService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function editar()
    {
        $cuenta = $this->cuentaActual();
        $esEmpresa = $cuenta instanceof Empresa;

        return view('Publico.perfilEditar', compact('cuenta', 'esEmpresa'));
    }

    public function actualizar(Request $request, usuariosService $usuariosService, empresasServices $empresasServices)
    {
        $cuenta = $this->cuentaActual();

        if ($cuenta instanceof Empresa) {
            $datos = $request->validate([
                'nombreEmpresa' => ['required', 'string', 'max:100'],
                'nit' => ['required', 'string', 'max:30', Rule::unique('empresas', 'nit')->ignore($cuenta->id)],
                'direccion' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('empresas', 'email')->ignore($cuenta->id)],
                'fotoPerfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);

            $empresasServices->actualizar($cuenta->id, $datos);
        } else {
            $datos = $request->validate([
                'nombres' => ['required', 'string', 'max:100'],
                'apellidos' => ['required', 'string', 'max:100'],
                'fechaNacimiento' => ['required', 'date'],
                'tipoDocumento' => ['required', Rule::in(['CC', 'CE', 'PPT', 'PEP', 'PASAPORTE'])],
                'numeroDocumento' => ['required', 'string', 'max:30', Rule::unique('usuarios', 'numeroDocumento')->ignore($cuenta->id)],
                'telefono' => ['required', 'string', 'max:20'],
                'email' => ['required', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($cuenta->id)],
                'fotoPerfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);

            $usuariosService->actualizar($cuenta->id, $datos);
        }

        return redirect()->route('perfil.editar')->with('success', 'Tu perfil se actualizó correctamente.');
    }

    public function calificaciones(calificacionService $calificacionService)
    {
        $calificaciones = $calificacionService->historialDeCuenta($this->cuentaActual());

        return view('Publico.partials.calificaciones', compact('calificaciones'));
    }

    private function cuentaActual(): Usuario|Empresa
    {
        $cuenta = auth('empresa')->user() ?? auth('web')->user();
        abort_unless($cuenta instanceof Usuario || $cuenta instanceof Empresa, 403);

        return $cuenta;
    }
}
