<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OfertaServiciosUpdateRequest extends FormRequest
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
            'idServicio' => 'required|exists:servicios,id',
            'idOferta' => 'required|exists:ofertas,id',
        ];
    }

        public function messages():array
    {
        return [
            'idServicio.required' => 'El servicio es obligatorio.',
            'idServicio.exists' => 'El servicio seleccionado no existe.',

            'idOferta.required' => 'La oferta es obligatoria.',
            'idOferta.exists' => 'La oferta seleccionada no existe.',
            ];
    }
}
