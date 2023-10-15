<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_empleado extends Model
{
     protected $table='users_empleados';

    protected $fillable=[
    'id',
    'user_id',
    'empleado_id'
    ];

    public function user(){
    	return $this->belongsTo('App\user');
    }

    public function empleado(){
    	return $this->belongsTo('App\empleado');
    }
}
