<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajoServicio extends Model
{
    protected $table = 'orden_trabajo_servicio';

    protected $fillable=[
        'servicio_id',
        'orden_de_trabajo_id',
        'mano_obra'
        ];

    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }

    public function orden_de_trabajo(){
        return $this->belongsTo(OrdenDeTrabajo::class);
    }
}
