<?php

namespace App\Http\Controllers;

use App\Http\Requests\CambiarContrasenaRequest;
use App\Http\Requests\PerfilUpdateRequest;
use App\Models\Empresa;
use App\Models\Usuario;
use App\Services\calificacionService;
use App\Services\perfilService;
use Exception;
use Illuminate\Validation\ValidationException;

class PerfilController extends Controller
{
    public function editar(perfilService $perfilService)
    {
        return view('Publico.perfilEditar', $perfilService->datosParaEditar($this->cuentaActual()));
    }

    public function actualizar(PerfilUpdateRequest $request, perfilService $perfilService)
    {
        try {
            $perfilService->actualizarPerfil($this->cuentaActual(), $request->validated());
        } catch (ValidationException $e) {
            throw $e; // errores por campo (ej. menor de edad): Laravel los muestra junto al campo
        } catch (Exception $e) {
            return redirect()->route('perfil.editar')->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('perfil.editar')->with('success', 'Tu perfil se actualizó correctamente.');
    }

    public function cambiarContrasena(CambiarContrasenaRequest $request, perfilService $perfilService)
    {
        try {
            $perfilService->cambiarContrasena(
                $this->cuentaActual(),
                $request->validated('contrasena_actual'),
                $request->validated('password')
            );
        } catch (Exception $e) {
            return redirect(route('perfil.editar') . '#cambiar-contrasena')
                ->withErrors(['servicio' => $e->getMessage()], 'contrasena');
        }

        return redirect(route('perfil.editar') . '#seguridad')
            ->with('contrasenaActualizada', 'Tu contraseña se actualizó correctamente.');
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
