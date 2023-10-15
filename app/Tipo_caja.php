<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_caja extends Model
{
    protected $table = 'tipos_caja';

    protected $fillable=[
        'id',
        'tipo_caja',
        ];

    public function tipo_caja(){
        return $this->hasMany(Vehiculo::class);
    }
    
    
}
