<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable=[
        'id',
        'user_id',
        'fecha_factura',
        'proveedor_id',
        'serie_factura',
        'num_factura',
        'total_factura',
        'edo_ingreso_id',
        'tipo_pago_id'
        ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function detalles_compras(){
        return $this->hasMany(DetalleCompra::class);
    }

    public function movimientoproducto(){
        return $this->hasMany(MovimientoProducto::class);
    }

    public function estadoingreso(){
    	return $this->belongsTo(EstadoIngreso::class);
    }

    public function tipo_pago(){
    	return $this->belongsTo(TipoPago::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
