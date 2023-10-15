<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleConversion extends Model
{
    protected $table = 'detalles_conversiones';

    protected $fillable=[
        'id',
        'producto_id_ingresa',
        'producto_id_sale',
        'conversion_producto_id',
        'movimiento_producto_id'
        ];


    public function conversion_producto(){
        return $this->belongsTo(ConversionProducto::class);
    }

       public function movimiento_producto(){
        return $this->belongsTo(MovimientoProducto::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

}
