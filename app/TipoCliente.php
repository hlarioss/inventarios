<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
    protected $table = 'tipos_cliente';
    protected $fillable=[
        'id', 'nombre', 'descuento', 'monto_mensual'
    ];

    public function clientes(){
        return $this->hasMany('App\Cliente');
       }
}
