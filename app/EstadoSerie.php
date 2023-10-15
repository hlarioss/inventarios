<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoSerie extends Model
{
    protected $table = 'estados_serie';
    
    protected $fillable=[
        'id',
        'estado',
    ];

    public function series(){
        return $this->hasMany(Serie::class);
    }

}
