<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = ['titulo','descripcion','requisitos','salario','tipoContrato','ubicacion','fechaPublicacion','fechaLimite','idEmpresa', ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idEmpresa');
    }

    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'idOferta');
    }

    public function ofertaServicio()
    {
        return $this->hasMany(OfertaServicio::class,'idOferta'); /*Relación con la tabla ofertaServicios*/
    }
}
