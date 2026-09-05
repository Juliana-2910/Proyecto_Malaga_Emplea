<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre'];

    public function servicios()
    {
        return $this->hasMany(Servicios::class, 'idCategoria'); /*Tabla Padre con servicios*/
    }
}
