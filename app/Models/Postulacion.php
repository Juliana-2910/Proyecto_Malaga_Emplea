<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Postulacion extends Model
{
     use HasFactory;

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
