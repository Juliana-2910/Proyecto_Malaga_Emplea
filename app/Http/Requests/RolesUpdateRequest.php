<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RolesUpdateRequest extends FormRequest
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
            'rol' => ['required', 'in:usuario,administrador'],
        ];
    }

    public function messages(): array
    {
        return [
            'rol.required' => 'El campo rol es obligatorio.',
            'rol.in' => 'El valor del campo rol debe ser "usuario" o "administrador".',
        ];
    }
}
