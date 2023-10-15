<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasificacionCliente extends Model
{
    protected $table = 'clasificaciones_cliente';

    protected $fillable=[
        'id',
        'nombre'
        ];

    public function clientes(){
        return $this->hasMany(Cliente::class);
    }
}
