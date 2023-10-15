<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrarDetalle extends Model
{
    protected $table = 'cuentas_por_cobrar_detalle';

    protected $fillable=[
        'id',
        'cuentas_por_cobrar_id',
        'venta_id',
        'fecha',
        'num_factura',
        'descripcion',
        'cargos',
        'abonos',
        'saldo'
        ];

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function cuentas_por_cobrar(){
        return $this->belongsTo(CuentasPorCobrar::class);
    }

}
