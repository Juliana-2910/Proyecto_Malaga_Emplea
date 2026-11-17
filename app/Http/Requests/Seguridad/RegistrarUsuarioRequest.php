<?php

namespace App\Http\Requests\Seguridad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrarUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'fechaNacimiento' => 'required|date',
            'tipoDocumento' => [
                'required',
                Rule::in(['CC', 'CE', 'PPT', 'PEP', 'PASAPORTE']),
            ],
            'numeroDocumento' => 'required|string|max:30|unique:usuarios,numeroDocumento',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'password' => 'required|string|min:8',
            'terminos' => 'required|accepted',
            'datos' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'numeroDocumento.unique' => 'Este número de documento ya se encuentra registrado.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
            'terminos.required' => 'Debes aceptar los Términos y Condiciones.',
            'terminos.accepted' => 'Debes aceptar los Términos y Condiciones.',
            'datos.required' => 'Debes autorizar el tratamiento de tus datos personales.',
            'datos.accepted' => 'Debes autorizar el tratamiento de tus datos personales.',
        ];
    }
}
