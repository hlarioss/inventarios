<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='ventas_maestro';

    protected $fillable=[
    'id',
    'tipo_pago_id',
    'total_venta',
    'user_id',
    'edo_venta_id',
    'cliente_id',
    'tipo_venta_id'
    ];

    public function tipoventa(){
    	return $this->belongsTo('App\Tipopago');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function estadoventa(){
    	return $this->belongsTo('App\EstadoVenta');
    }

    public function ventadetalle(){
    	return $this->hasMany('App\VentaDetalle', "venta_id", "id");
    }
    public function cuentas_por_cobrar(){
    	return $this->hasMany('App\CuentasPorCobrar');
    }
    public function clientes(){
    	return $this->hasMany(Cliente::class);
    }
    
}
