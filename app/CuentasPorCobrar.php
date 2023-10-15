<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentasPorCobrar extends Model
{
    protected $table = 'cuentas_por_cobrar';

    protected $fillable=[
        'id',
        'cliente_id',
        'total',
        'estado',
    
        ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function ventas(){
        return $this->belongsTo(Venta::class);
    }
    public function cuentas_por_cobrar_detalle(){
        return $this->hasMany(CuentaPorCobrarDetalle::class);
    }

}
