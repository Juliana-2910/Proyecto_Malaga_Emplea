<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Usuario;
use App\Services\calificacionService;
use App\Services\empresasServices;
use App\Services\usuariosService;
use App\Services\hojaDeVidaService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function editar(hojaDeVidaService $hojaDeVidaService)
    {
        $cuenta = $this->cuentaActual();
        $esEmpresa = $cuenta instanceof Empresa;

        $hojaDeVida = $cuenta instanceof Usuario ? $hojaDeVidaService->buscarPorUsuario($cuenta->id) : null;
        return view('Publico.perfilEditar', compact('cuenta', 'esEmpresa', 'hojaDeVida'));
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
                'eliminarFotoPerfil' => ['nullable', 'boolean'],
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
                'eliminarFotoPerfil' => ['nullable', 'boolean'],
            ]);

            $usuariosService->actualizar($cuenta->id, $datos);
        }

        return redirect()->route('perfil.editar')->with('success', 'Tu perfil se actualizó correctamente.');
    }

    public function calificaciones(calificacionService $calificacionService)
    {
        return $this->mostrarCalificaciones($this->cuentaActual(), $calificacionService);
    }

    public function calificacionesPublicas(string $tipo, int $id, calificacionService $calificacionService)
    {
        abort_unless(in_array($tipo, ['usuario', 'empresa'], true), 404);
        $cuenta = $calificacionService->cuentaCalificable($tipo, $id);
        return $this->mostrarCalificaciones($cuenta, $calificacionService);
    }

    private function mostrarCalificaciones(Usuario|Empresa $cuenta, calificacionService $calificacionService)
    {
        $calificaciones = $calificacionService->historialDeCuenta($cuenta);
        $reputacion = $calificacionService->promedioRecibido($cuenta);
        $nombreCuenta = $cuenta instanceof Empresa ? $cuenta->nombreEmpresa : trim($cuenta->nombres . ' ' . $cuenta->apellidos);
        $esEmpresa = $cuenta instanceof Empresa;
        $foto = $cuenta->fotoPerfil ? asset('storage/' . ($esEmpresa ? 'empresas/' . $cuenta->fotoPerfil : $cuenta->fotoPerfil)) : null;

        return view('Publico.partials.calificaciones', compact('calificaciones', 'cuenta', 'reputacion', 'nombreCuenta', 'esEmpresa', 'foto'));
    }

    private function cuentaActual(): Usuario|Empresa
    {
        $cuenta = request()->user();
        abort_unless($cuenta instanceof Usuario || $cuenta instanceof Empresa, 403);

        return $cuenta;
    }
}
