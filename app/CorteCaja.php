<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorteCaja extends Model
{
    protected $table = 'cortes_caja';

    protected $fillable=[
        'id',
        'fecha',
        'factura_inicial',
        'factura_final',
        'total',
        'efectivo',
        'credito',
        'voucher',
        'totalSF',
        'efectivoSF',
        'creditoSF',
        'voucherSF',
        'total_venta',
        'user_id'

        ];
}
