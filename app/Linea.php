<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    protected $table = 'linea';

    protected $fillable=[
        'id',
        'linea',
        'marca_id',
        ];

    public function linea(){
        return $this->hasMany(Vehiculo::class);
    }
    
    public function marca(){
        return $this->belongsTo(Marca::class);
    }
}
