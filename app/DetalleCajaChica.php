<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCajaChica extends Model
{
    protected $table = 'detalles_cajas_chicas';

    protected $fillable=[
        'id',
        'documento',
        'fecha',
        'descripcion',
        'caja_chica_id',
        'user_id',
        'gasto',
        'ingreso',
        'saldo'
        ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function caja_chica(){
        return $this->belongsTo(CajaChica::class);
    }

}
