<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaChica extends Model
{
    protected $table = 'cajas_chicas';

    protected $fillable=[
        'id',
        'saldo'
        ];


    public function detalles_cajas_chicas(){
        return $this->hasMany(DetalleCajaChica::class);
    }
}
