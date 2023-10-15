<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePlanilla extends Model
{
    protected $table = 'detalles_planillas';

    protected $fillable=[
        'id',
        'empleado_id',
        'planilla_id',
        'bono_incentivo',
        'horas_extra',
        'igss',
        'isr',
        'user_id',
        'sueldo'
        ];


    public function planilla(){
        return $this->belongsTo(Planilla::class);
    }

    public function empleado(){
        return $this->belongsTo(Empleado::class);
    }

}
