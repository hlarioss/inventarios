<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleServicio extends Model
{
    protected $table = 'detalles_servicios';

    protected $fillable=[
        'id',
        'producto_id',
        'user_id',
        'maquinaria_equipo_id',
        'servicio_id',
        'costo',
        'cantidad'

        ];

    public function maquinaria(){
        return $this->belongsTo(MaquinariaEquipo::class);
    }

    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
