<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaPorPagar extends Model
{
    protected $table = 'cuentas_por_pagar';

    protected $fillable=[
        'id',
        'proveedor_id',
        'total'
        ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function detalles_cuentas_por_pagar(){
        return $this->hasMany(DetalleCuentaPorPagar::class);
    }
}
