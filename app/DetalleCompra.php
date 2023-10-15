<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalles_compras';

    protected $fillable=[
        'id',
        'fecha_ingreso',
        'precio_compra',
        'precio_venta',
        'producto_id',
        'existencias',
        'user_id',
        'maquinaria_equipo_id',
        'compra_id',
        'movimiento_producto_id'
        ];

    public function maquinaria(){
        return $this->belongsTo(MaquinariaEquipo::class);
    }

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

       public function movimientoproducto(){
        return $this->belongsTo(MovimientoProducto::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }

}
