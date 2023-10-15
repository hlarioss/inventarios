<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCuentaPorPagar extends Model
{
    protected $table = 'detalles_cuentas_por_pagar';

    protected $fillable=[
        'id',
        'cuenta_por_pagar_id',
        'compra_id',
        'fecha',
        'num_factura',
        'descripcion',
        'cargos',
        'abonos',
        'saldo'
        ];

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

    public function cuenta_por_pagar(){
        return $this->belongsTo(CuentaPorPagar::class);
    }

}
