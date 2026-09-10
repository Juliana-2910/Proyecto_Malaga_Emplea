<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CalificacionUpdateRequest extends FormRequest
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
            'puntuacion' => 'required|string|min:1|max:5',
            'comentario' => 'required|string|max:255',
            'idUsuario' => 'required|exists:usuarios,id',
            'idEmpresa' => 'required|exists:empresas,id',
        ];
    }

    public function messages():array
    {
        return [
            'puntuacion.required' =>'La puntuación es obligatoria.',
            'puntuacion.string' =>'La puntuación debe ser un número entero.',
            'puntuacion.max' =>'La puntuación no puede ser menor que 1.',
            'puntuacion.min' =>'La puntuación no puede ser mayor que 5.',

            'comentario.required' =>'El comentario es obligatorio.',
            'comentario.string' =>'El comentario debe ser un texto.',
            'comentario.max' =>'',

            'idUsuario.required' => 'El usuario es obligatorio.',
            'idUsuario.exists' => 'El usuario seleccionado no existe.',

            'idEmpresa.required' => 'La empresa es obligatoria.',
            'idEmpresa.exists' => 'La empresa seleccionada no existe.',
            ];
    }
}
