<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colores';

    protected $fillable=[
        'id',
        'color',
        ];

    public function color(){
        return $this->hasMany(Vehiculo::class);
    }
}
