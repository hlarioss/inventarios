<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MantenimientoEquipo extends Model
{
    protected $table = 'mantto_equipo';
    
    protected $fillable=[
        'id',
        'descripcion',
        'fecha_proximo_servicio',
        'fecha_servicio',
        'labadas_servicio',
        'labadas_proximo_servicio',
        'maquinaria_id',
        'proveedor_id'
        ];

    public function maquinarias_y_equipo(){
        return $this->belongsTo(MaquinariaEquipo::class);
    }

    public function proveedores(){
        return $this->belongsTo(Proveedor::class);
    }
}
