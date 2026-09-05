<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HojaDeVida extends Model
{
    protected $table = 'hojaDeVida';

    protected $fillable = ['ubicacion', 'nivelEducativo', 'perfilProfesional',
    'experienciaLaboral', 'fechaActualizacion', 'archivoCV', 'idUsuario'];

    public function usuario()
    {
    return $this->belongsTo(Usuario::class, 'idUsuario'); /*Tabla Hija con usuario*/
    }
}
