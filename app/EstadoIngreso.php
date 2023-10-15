<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoIngreso extends Model
{
    protected $table='estado_ingresos';

    protected $fillable=[
    'id',
    'edo_ingreso'
    ];

    public function ingresoproducto(){
    	return $this->hasMany(IngresoProducto::class);
    }
}
