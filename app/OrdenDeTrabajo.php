<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenDeTrabajo extends Model
{
    protected $table = 'ordenes_de_trabajo';

    protected $fillable=[
        'id',
        'fecha_hora',
        'resp_recepcion',
        'fecha_prometida',
        'cliente_id',
        'vehiculo_id',
        'estado_id',
        'total'
        ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class);
    }
    public function componentes_accesorios(){
        return $this->hasMany(ComponentesAccesorios::class);
    }
    public function photos(){
        return $this->hasMany(Photo::class);
    }
    public function orden_trabajo_servicio(){
        return $this->hasMany(OrdenTrabajoServicio::class);
    }
}
