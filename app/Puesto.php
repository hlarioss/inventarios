<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'puestos';
    
    protected $fillable=[
        'id',
        'nombre',
        'sueldo'
        ];

    public function empleados(){
        return $this->hasMany(Empleado::class);
    }

}
