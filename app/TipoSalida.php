<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoSalida extends Model
{
    protected $table='tipos_salida';

    protected $fillable=[
    'id',
    'tipo_salida'
    ];

    public function salidaproducto(){
        return $this->hasMany('App\SalidaProducto');
    }
}
