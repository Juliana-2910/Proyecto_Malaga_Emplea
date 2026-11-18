<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HojaDeVida extends Model
{
    use HasFactory;

    protected $table = 'hojaDeVida';

    protected $fillable = ['ubicacion', 'nivelEducativo', 'perfilProfesional',
    'experienciaLaboral', 'fechaActualizacion', 'archivoCV', 'idUsuario'];

    public function usuario()
    {
    return $this->belongsTo(Usuario::class, 'idUsuario'); /*Tabla Hija con usuario*/
    }
}
