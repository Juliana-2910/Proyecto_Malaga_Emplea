<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [ 'nombreEmpresa','nit','direccion','estado','correoElectronico','password',
    ];

    public function ofertas()
    {
        return $this->hasMany(Oferta::class, 'idEmpresa');
    }

    public function calificacion()
    {
        return $this->hasMany(Calificacion::class,'idEmpresa');
    }

}
