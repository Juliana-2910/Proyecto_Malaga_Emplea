<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UsuariosStoreRequest extends FormRequest
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
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fotoPerfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fechaNacimiento' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'tipoDocumento' => 'required|in:CC,CE,PPT,PEP,PASAPORTE',
            'numeroDocumento' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'telefono' => 'required|string|max:20',
            'estado' => 'required|in:activo,inactivo',
        ];
        }
    public function messages(): array
    {
        return [
            'nombres.required' => 'El campo nombres es obligatorio.',
            'nombres.max' => 'El campo nombres no debe exceder los 255 caracteres.',

            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.string' => 'El campo apellidos debe ser una cadena de texto.',
            'apellidos.max' => 'El campo apellidos no debe exceder los 255 caracteres.',

            'fotoPerfil.image' => 'El archivo debe ser una imagen.',
            'fotoPerfil.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg',
            'fotoPerfil.max' => 'El tamaño de la imagen no debe exceder los 2MB.',

            'fechaNacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'fechaNacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            'fechaNacimiento.before_or_equal' => 'El usuario debe tener mínimo 18 años para registrarse.',

            'tipoDocumento.required' => 'El campo tipo de documento es obligatorio.',
            'tipoDocumento.in' => 'El campo tipo de documento debe ser uno de los valores permitidos.',

            'numeroDocumento.required' => 'El campo número de documento es obligatorio.',
            'numeroDocumento.string' => 'El campo número de documento debe ser una cadena de texto.',
            'numeroDocumento.max' => 'El campo número de documento no debe exceder los 255 caracteres.',

            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.string' => 'El campo correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El campo correo electrónico no debe exceder los 255 caracteres.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'El campo contraseña debe ser una cadena de texto.',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres.',

            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.string' => 'El campo teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El campo teléfono no debe exceder los 20 caracteres.',

            'estado.required' => 'El campo estado es obligatorio.',
            'estado.in' => 'El campo estado debe ser uno de los valores permitidos.',

        ];
    }
}
