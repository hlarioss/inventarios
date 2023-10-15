<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transmision extends Model
{
    protected $table = 'transmision';
    protected $fillable=[
        'id', 
        'transmision'
    ];

    public function vehiculos(){
        return $this->hasMany(Vehiculo::class);
    }
}
