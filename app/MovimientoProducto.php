<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoProducto extends Model
{
    protected $table='movimientos_productos';

    protected $fillable=[
    'id',
    'fecha_ingreso',
    'producto_id',
    'paquete',
    'existencias',
    'precio_compra',
    'precio_venta',
    'maquinaria_equipo_id',
    'vendido'
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

    public function detallescompras(){
        return $this->hasMany(DetalleCompra::class);
    }

    public function ventadetalle(){
        return $this->hasMany(VentaDetalle::class);
    }

    public function salidaproducto(){
        return $this->hasMany(SalidaProducto::class);
    }

    public function ingresos_productos(){
        return $this->hasMany(IngresoProducto::class);
    }

}
