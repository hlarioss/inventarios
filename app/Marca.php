<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';
    protected $fillable=[
        'id', 'nombre', 'tipo_marca_id'
    ];

    public function vehiculos(){
        return $this->hasMany(Vehiculo::class);
    }

    public function maquinarias_y_equipo(){
        return $this->hasMany(MaquinariaEquipo::class);
    }
}
