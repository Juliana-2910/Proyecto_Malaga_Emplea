<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EmpresaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'nombreEmpresa' => 'required|string|max:100',
        'nit' => 'required|string|unique:empresas,nit,' . $this->route('empresa'),
        'direccion' => 'required|string|max:255',
        'estado' => 'required|in:activo,inactivo',
        'correoElectronico' => 'required|email|max:255',
        'password' => 'nullable|string|min:8',
    ];
}

public function messages(): array
{
    return [
        'nombreEmpresa.required' => 'El nombre de la empresa es obligatorio.',
        'nombreEmpresa.max' => 'El nombre de la empresa no puede superar los 100 caracteres.',

        'nit.required' => 'El NIT es obligatorio.',
        'nit.unique' => 'El NIT ingresado ya se encuentra registrado.',

        'direccion.required' => 'La dirección es obligatoria.',

        'estado.required' => 'El estado de la empresa es obligatorio.',
        'estado.in' => 'El estado debe ser "activo" o "inactivo".',

        'correoElectronico.required' => 'El correo electrónico es obligatorio.',
        'correoElectronico.email' => 'Ingrese un correo electrónico válido.',

        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
    ];
}


}
