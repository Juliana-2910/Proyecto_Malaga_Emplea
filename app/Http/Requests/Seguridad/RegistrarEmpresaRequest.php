<?php

namespace App\Http\Requests\Seguridad;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombreEmpresa' => 'required|string|max:150',
            'nit' => 'required|string|max:30|unique:empresas,nit',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:empresas,email',
            'password' => 'required|string|min:8',
            'terminos' => 'required|accepted',
            'datos' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'nit.unique' => 'Este NIT ya se encuentra registrado.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
            'terminos.required' => 'Debes aceptar los Términos y Condiciones.',
            'terminos.accepted' => 'Debes aceptar los Términos y Condiciones.',
            'datos.required' => 'Debes autorizar el tratamiento de tus datos personales.',
            'datos.accepted' => 'Debes autorizar el tratamiento de tus datos personales.',
        ];
    }
}
