<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalificarPostulanteRequest extends FormRequest
{
    // Los errores van en su propio "bolsillo" para no abrir otros modales.
    protected $errorBag = 'calificar';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'idUsuario'  => 'required|exists:usuarios,id', // TEMPORAL: con el login sale de la sesión
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'puntuacion.required' => 'Elige de 1 a 5 estrellas.',
            'puntuacion.min'      => 'Elige de 1 a 5 estrellas.',
            'puntuacion.max'      => 'Elige de 1 a 5 estrellas.',
            'comentario.required' => 'Cuéntanos cómo fue tu experiencia.',
            'comentario.max'      => 'El comentario no puede superar los 500 caracteres.',
        ];
    }
}
