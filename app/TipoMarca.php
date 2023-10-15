<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMarca extends Model
{
    protected $table = 'tipos_marca';
    protected $fillable=[
        'id', 'nombre'
    ];

    public function marcas(){
        return $this->hasMany(Marca::class);
       }
}
