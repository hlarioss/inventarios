<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direccion';

    protected $fillable=[
        'id',
        'tipo_direccion',
        ];

    public function tipo_direccion(){
        return $this->hasMany(Vehiculo::class);
    }
}
