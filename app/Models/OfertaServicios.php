<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaServicios extends Model
{
    protected $table = 'ofertaServicios';

    protected $fillable = ['idServicio','idOferta'];

    public function servicio()
    {
        return $this->belongsTo(Servicios::class,'idServicio');
    }

    public function oferta()
    {
        return $this->belongsTo(Oferta::class,'idOferta');
    }
}
