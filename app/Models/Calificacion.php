<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificacion';

    protected $fillable = ['puntuacion','comentario',
    'fecha','idUsuario','idEmpresa'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class,'idUsuario');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class,'idEmpresa');
    }
}
