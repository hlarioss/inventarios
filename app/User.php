<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Kodeine\Acl\Traits\HasRole;

class User extends Authenticatable
{
    use HasRole;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password','username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function precios_producto(){
        return $this->hasMany(PrecioProducto::class);
    }


    public function clientes(){
        return $this->hasMany(Cliente::class);
    }

    public function ingresos_productos(){
        return $this->hasMany(IngresoProducto::class);
    }
}
