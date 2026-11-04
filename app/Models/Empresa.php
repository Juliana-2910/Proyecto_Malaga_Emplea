<?php

namespace App\Models;

use App\Models\Concerns\TieneRolesActivos;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;

class Empresa extends Authenticatable
{
    use TieneRolesActivos;

    protected $table = 'empresas';

    protected string $guard_name = 'web';

    protected $fillable = [ 'nombreEmpresa','fotoPerfil','nit','direccion','estado','correoElectronico','password',
    ];

    protected $hidden = ['password'];

    protected static function booted(): void
    {
        static::created(function (self $empresa): void {
            $rol = Role::findOrCreate(config('seguridad.rol_empresa'), config('seguridad.guard'));

            $empresa->assignRole($rol);
        });
    }

    public function getRememberTokenName(): string
    {
        return '';
    }

    protected function name(): Attribute
    {
        return Attribute::make(get: fn () => $this->nombreEmpresa);
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class, 'idEmpresa');
    }

    public function calificacion()
    {
        return $this->hasMany(Calificacion::class,'idEmpresa');
    }
}
