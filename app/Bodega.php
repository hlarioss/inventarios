<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    protected $table = 'bodegas';

    protected $fillable=[
        'id',
        'bodega',
        'estado'
        ];

    public function localidad(){
        return $this->hasMany(Localidad::class);
    }
}
