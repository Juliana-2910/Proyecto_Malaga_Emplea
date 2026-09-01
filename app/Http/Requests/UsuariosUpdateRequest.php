<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UsuariosUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'tipoDocumento' => 'required|in:CC,CE,PPT,PEP',
            'numeroDocumento' => 'required|string|max:255|unique:usuarios,numeroDocumento',
            'correoElectronico' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required|string|max:20',
            'fechaRegistro' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo',
            'idRol' => 'required|exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombres.required' => 'El campo nombres es obligatorio.',
            'nombres.string' => 'El campo nombres debe ser una cadena de texto.', 
            'nombres.max' => 'El campo nombres no debe exceder los 255 caracteres.',

            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.string' => 'El campo apellidos debe ser una cadena de texto.',
            'apellidos.max' => 'El campo apellidos no debe exceder los 255 caracteres.',

            'fechaNacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'fechaNacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',

            'tipoDocumento.required' => 'El campo tipo de documento es obligatorio.',
            'tipoDocumento.in' => 'El campo tipo de documento debe ser uno de los valores permitidos.',

            'numeroDocumento.required' => 'El campo número de documento es obligatorio.',
            'numeroDocumento.string' => 'El campo número de documento debe ser una cadena de texto.',
            'numeroDocumento.max' => 'El campo número de documento no debe exceder los 255 caracteres.',
            'numeroDocumento.unique' => 'El campo número de documento ya está en uso.',

            'correoElectronico.required' => 'El campo correo electrónico es obligatorio.',
            'correoElectronico.string' => 'El campo correo electrónico debe ser una cadena de texto.',
            'correoElectronico.email' => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'correoElectronico.max' => 'El campo correo electrónico no debe exceder los 255 caracteres.',
            'correoElectronico.unique' => 'El campo correo electrónico ya está en uso.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'El campo contraseña debe ser una cadena de texto.',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Los campos contraseña y confirmación de contraseña no coinciden.',

            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.string' => 'El campo teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El campo teléfono no debe exceder los 20 caracteres.',

            'fechaRegistro.required' => 'El campo fecha de registro es obligatorio.',
            'fechaRegistro.date' => 'El campo fecha de registro debe ser una fecha válida.',

            'estado.required' => 'El campo estado es obligatorio.',
            'estado.in' => 'El campo estado debe ser uno de los valores permitidos.',

            'idRol.required' => 'El campo rol es obligatorio.',
            'idRol.exists' => 'El rol seleccionado no existe.',
        ];
    }
}
