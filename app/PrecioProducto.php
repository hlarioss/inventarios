<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrecioProducto extends Model
{
    protected $table = 'precios_producto';

    protected $fillable=[
        'id',
        'precio_venta',
        'producto_id',
        'user_id',
        'fecha'
        ];


    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
