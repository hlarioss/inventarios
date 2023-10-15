<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table ='vehiculos';

    protected $fillable=[
        'id',
        'placa',
        'tipo_vehiculo_id',
        'marca_id',
        'linea_id',
        'kilometraje',
        'anio',
        'color_id',
        'fecha_ultimo_servicio',
        'vin',
        'cliente_id',
        'direccion_id',

        'transmision_id',
        'traccion_id',
        'diferenciales',
        'tipo_caja_id',
        'aceite_caja_fabrica',
        'aceite_caja',
        'cantidad_aceite_caja',
        'viscosidad_caja',


        'combustible_id',
        'no_motor',
        'ccs',
        'cilindros',
        'aceite_motor_fabrica',
        'aceite_motor',
        'cantidad_aceite_motor',
        'viscosidad_motor',
        'observaciones'

    ];
    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculo::class);
    }

    public function marca(){
        return $this->belongsTo(Marca::class);
    }
    public function linea(){
        return $this->belongsTo(Linea::class);
    }
    public function colores(){
        return $this->belongsTo(Color::class);
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function tipo_transmision(){
        return $this->belongsTo(Transmision::class);
    }
    public function tipo_traccion(){
        return $this->belongsTo(Traccion::class);
    }
    public function tipo_caja(){
        return $this->belongsTo(Tipo_caja::class);
    }
    
    public function combustible(){
        return $this->belongsTo(Combustible::class);
    }
    
    
   
}
