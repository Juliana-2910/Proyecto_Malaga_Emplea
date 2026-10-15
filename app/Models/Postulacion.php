<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
     protected $table = 'postulacion';

     protected $fillable = ['fecha','estado','idUsuario','idOferta'
    ];

    public function usuario()
     {
    return $this->belongsTo(Usuario::class, 'idUsuario');
     }
    
    public function oferta()
     {
    return $this->belongsTo(Oferta::class, 'idOferta');
     }
}
