<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoVenta extends Model
{
    protected $table='estado_ventas';

    protected $fillable=[
    'id',
    'edo_venta'
    ];

    public function venta(){
    	return $this->hasMany('App\Venta');
    }
}