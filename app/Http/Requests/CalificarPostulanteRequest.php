<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalificarPostulanteRequest extends FormRequest
{
    // Los errores van en su propio "bolsillo" para no abrir otros modales.
    protected $errorBag = 'calificar';

    // Quien publica la oferta (empresa o persona) califica a la persona contratada.
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'puntuacion' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'puntuacion.required' => 'Elige de 1 a 5 estrellas.',
            'puntuacion.min'      => 'Elige de 1 a 5 estrellas.',
            'puntuacion.max'      => 'Elige de 1 a 5 estrellas.',
            'comentario.required' => 'Cuéntanos cómo fue la experiencia.',
            'comentario.max'      => 'El comentario no puede superar los 100 caracteres.',
        ];
    }
}
