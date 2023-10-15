<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';

    protected $fillable=[
        'id',
        'numero',
        'fecha',
        'total',
        'voucher',
        'tipo_pago_id',
        'user_id',
        'serie_id',
        'venta_id',


        ];

    public function series(){
        return $this->belongsTo(Serie::class);
    }
    public function pagos(){
        return $this->belongsTo(TipoPago::class);
    }
}
