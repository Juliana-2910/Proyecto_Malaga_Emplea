<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CambiarContrasenaRequest extends FormRequest
{
    // Los errores van en su propia "bolsa" para que no se mezclen con los del perfil.
    protected $errorBag = 'contrasena';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contrasena_actual' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'contrasena_actual.required' => 'Escribe tu contraseña actual.',
            'password.required' => 'Escribe la nueva contraseña.',
            'password.min' => 'La nueva contraseña debe tener mínimo 8 caracteres.',
            'password.confirmed' => 'La confirmación no coincide con la nueva contraseña.',
        ];
    }

    // Hace que, si hay errores, la página vuelva con la sección abierta.
    protected function getRedirectUrl(): string
    {
        return route('perfil.editar') . '#cambiar-contrasena';
    }
}
