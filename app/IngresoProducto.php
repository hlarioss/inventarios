<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoProducto extends Model
{
    protected $table='ingresos_productos';

	protected $fillable=[
	'id',
	'producto_id',
	'cantidad',
	'fecha_ingreso',
	'user_id',
	'precio_venta',
	'movimiento_producto_id',
	'precio_compra'
	];

	public function producto(){
		return $this->belongsTo(Producto::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function movimiento_producto(){
		return $this->belongsTo(MovimientoProducto::class);
	}

}
