<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = 'tipos_servicio';
    
    protected $fillable=[
        'id',
        'nombre'
    ];

    public function servicios(){
        return $this->hasMany(Servicio::class);
    }
}
