<?php

namespace App\Http\Requests;

use App\Models\Usuario;

class CalificarContratacionRequest extends CalificarPostulanteRequest
{
    // La persona contratada califica a quien publicó: solo cuentas de persona.
    public function authorize(): bool
    {
        return $this->user() instanceof Usuario;
    }
}
