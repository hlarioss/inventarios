<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table='bitacoras';

    protected $fillable=[
    'id',
    'user_id',
    'accion',
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
