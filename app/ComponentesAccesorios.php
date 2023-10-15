<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentesAccesorios extends Model
{
    protected $table = 'componentes_accesorios';

    protected $fillable=[
        'id',
        'emblemas',
        'encendedor',
        'espejos',
        'antena',
        'radio',
        'llavero',
        'placas',
        'platos',
        'tapon_combustible',
        'soporte_bateria',
        'papeles',
        'alfombras',
        'control_alarma',
        'extinguidor',
        'triangulos',
        'vidrios_electricos',
        'conos',
        'neblineras',
        'luces',
        'llanta_repuesto',
        'llave_ruedas',
        'tricket',
        'descripcion',
        'orden_id',
        'combustible'
    ];

    public function orden_trabajo(){
        return $this->belongsTo(OrdenDeTrabajo::class);
    }
}