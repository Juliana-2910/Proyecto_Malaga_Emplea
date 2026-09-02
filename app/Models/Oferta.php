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
}
