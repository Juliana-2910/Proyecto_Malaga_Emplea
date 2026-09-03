<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HojaDeVidaStoreRequest extends FormRequest
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
            'ubicacion' => 'required|string|max:255',
            'nivelEducativo' => 'required|string|max:255',
            'perfilProfesional' => 'required|string|max:255',
            'experienciaLaboral' => 'required|string|max:255',
            'fechaActualizacion' => 'required|date',
            'archivoCV' => 'required|file|mimes:pdf|max:2048',
            'idUsuario' => 'required|exists:usuarios,id',
        ];
    }

        public function messages(): array
    {
        return [
            'ubicacion.required' => 'El campo ubicación es obligatorio.',
            'ubicacion.string' => 'El campo ubicación debe ser una cadena de texto.',
            'ubicacion.max' => 'El campo ubicación no debe exceder los 255 caracteres.',

            'nivelEducativo.required' => 'El campo nivel educativo es obligatorio.',
            'nivelEducativo.string' => 'El campo nivel educativo debe ser una cadena de texto.',
            'nivelEducativo.max' => 'El campo nivel educativo no debe exceder los 255 caracteres.',

            'perfilProfesional.required' => 'El campo perfil profesional es obligatorio.',
            'perfilProfesional.string' => 'El campo perfil profesional debe ser una cadena de texto.',
            'perfilProfesional.max' => 'El campo perfil profesional no debe exceder los 255 caracteres.',

            'experienciaLaboral.required' => 'El campo experiencia laboral es obligatorio.',
            'experienciaLaboral.string' => 'El campo experiencia laboral debe ser una cadena de texto.',
            'experienciaLaboral.max' => 'El campo experiencia laboral no debe exceder los 255 caracteres.',

            'fechaActualizacion.required' => 'El campo fecha de actualización es obligatorio.',
            'fechaActualizacion.date' => 'El campo fecha de actualización debe ser una fecha válida.',

            'archivoCV.required' => 'El archivo del CV es obligatorio.',
            'archivoCV.file' => 'Debe subir un archivo válido para el CV.',
            'archivoCV.mimes' => 'El archivo del CV debe ser un archivo PDF.',
            'archivoCV.max' => 'El archivo del CV no debe exceder los 2 MB.',

            'idUsuario.required' => 'El campo ID de usuario es obligatorio.',
            'idUsuario.exists' => 'El ID de usuario proporcionado no existe en la base de datos.',
        ];
    }
}
