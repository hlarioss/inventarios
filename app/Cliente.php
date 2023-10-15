<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable=[
        'id',
        'nombres',
        'apellidos',
        'nit',
        'dpi',
        'fecha_nacimiento',
        'clasificacion_cliente_id',
        'direccion',
        'telefonos',
        'record_compra',
        'tipo_cliente_id',
        'email',
        'user_id'
        ];

    public function tipo_cliente(){
        return $this->belongsTo(TipoCliente::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehiculos(){
        return $this->hasMany(Vehiculo::class);
    }
    public function ventas(){
        return $this->hasMany(Venta::class);
    }

    public function clasificacion_cliente(){
        return $this->belongsTo(ClasificacionCliente::class);
    }
}
