<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalidaProducto extends Model
{
    protected $table='salidas_productos';

    protected $fillable=[
    'id',
    'producto_id',
    'cantidad_salida',
    'fecha_salida',
    'user_id',
    'tipo_salida_id',
    'movimiento_producto_id'
    ];

    public function producto(){
    	return $this->belongsTo(Producto::class);
    }

    public function movimiento_producto(){
        return $this->belongsTo(MovimientoProducto::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function tipo_salida(){
    	return $this->belongsTo(TipoSalida::class);
    }

}
