<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $table = 'planillas';

    protected $fillable=[
        'id',
        'fecha',
        'total'
        ];


    public function detalles_planillas(){
        return $this->hasMany(DetallePlanilla::class);
    }

}
