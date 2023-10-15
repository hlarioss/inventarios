<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Combustible extends Model
{
    protected $table = 'combustible';

    protected $fillable=[
        'id',
        'combustible',
        ];

    public function combustible(){
        return $this->hasMany(Vehiculo::class);
    }
}
