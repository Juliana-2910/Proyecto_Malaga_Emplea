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
            'idPostulacion' => 'required|exists:postulacion,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:255',
            'tipoCalificador' => 'required|in:usuario,empresa',
        ];
    }

    public function messages():array
    {
        return [

            'idPostulacion.required' => 'La postulación es obligatoria.',
            'idPostulacion.exists' => 'La postulación seleccionada no existe.',

            'puntuacion.required' =>'La puntuación es obligatoria.',
            'puntuacion.integer' =>'La puntuación debe ser un número entero.',
            'puntuacion.min' =>'La puntuación no puede ser menor que 1.',
            'puntuacion.max' =>'La puntuación no puede ser mayor que 5.',

            'comentario.required' =>'El comentario es obligatorio.',
            'comentario.string' =>'El comentario debe ser un texto.',
            'comentario.max' => 'El comentario no puede superar los 255 caracteres.',

            'tipoCalificador.required' => 'Debes indicar quién realiza la calificación.',
            'tipoCalificador.in' => 'Debes seleccionar Usuario califica a empresa o Empresa califica a usuario.',
            ];
    }
}
