<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $table = 'tipos_pago';
    
    protected $fillable=[
        'id',
        'tipo_pago',
        
        ];

    public function facturas(){
        return $this->hasMany(Factura::class);
    }

    public function compras(){
        return $this->hasMany(Compra::class);
    }

}
