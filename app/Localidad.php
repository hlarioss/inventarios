<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidades';

    protected $fillable=[
        'id',
        'nombre',
        'bodega_id',
        'estado'
        ];

    public function bodega(){
        return $this->belongsTo(Bodega::class);
    }

    public function producto(){
        return $this->hasMany(Producto::class);
    }
    
    public function maquinaria(){
        return $this->hasMany(MaquinariaEquipo::class);
    }
    
}
