<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable=[
        'id',
        'emp_cui',
        'nombre',
        'apellido',
        'nit',
        'direccion',
        'telefono',
        'fecha_inicio',
        'fecha_nacimiento',
        'fecha_finalizacion',
        'puesto_id',
        ];

    public function puesto(){
        return $this->belongsTo(Puesto::class);
    }

    public function detalles_planillas(){
        return $this->hasMany(DetallePlanilla::class);
    }
}
