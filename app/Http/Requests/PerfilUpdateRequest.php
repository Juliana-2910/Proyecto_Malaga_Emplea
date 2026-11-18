<?php

namespace App\Http\Requests;

use App\Models\Empresa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerfilUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // las rutas ya están protegidas por auth y permisos
    }

    public function rules(): array
    {
        $cuenta = $this->user();
        $foto = [
            'fotoPerfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'eliminarFotoPerfil' => ['nullable', 'boolean'],
        ];

        if ($cuenta instanceof Empresa) {
            return [
                'nombreEmpresa' => ['required', 'string', 'max:100'],
                'nit' => ['required', 'string', 'max:30', Rule::unique('empresas', 'nit')->ignore($cuenta->id)],
                'direccion' => ['required', 'string', 'max:255'],
                'telefono' => ['nullable', 'string', 'max:20'],
                'email' => ['required', 'email', 'max:255', Rule::unique('empresas', 'email')->ignore($cuenta->id)],
            ] + $foto;
        }

        // Sin tipoDocumento ni numeroDocumento: ahora van congelados.
        return [
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'fechaNacimiento' => ['required', 'date'],
            'telefono' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($cuenta->id)],
        ] + $foto;
    }
}
