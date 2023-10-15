<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traccion extends Model
{
    protected $table = 'tracciones';
    protected $fillable=[
        'id', 
        'traccion'
    ];

    public function vehiculos(){
        return $this->hasMany(Vehiculo::class);
    }
}
