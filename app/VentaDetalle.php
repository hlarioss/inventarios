<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    protected $table='ventas_detalle';

    protected $fillable=[
    'id',
    'venta_id',
    'producto_id',
    'precio_id',
    'cantidad',
    'precio_compra',
    'precio_venta',
    'movimiento_producto_id',
    'subtotal',
    'servicio_id',
    'detalle_mano_obra',
    
    ];


    public function venta(){
    	return $this->belongsTo('App\Venta', "venta_id", "id");
    }

    public function producto(){
    	return $this->belongsTo('App\Producto');
    }
    public function servicios(){
    	return $this->belongsTo('App\Servicios');
    }
    public function movimientoproducto(){
        return $this->belongsTo('App\MovimientoProducto');
    }
}
