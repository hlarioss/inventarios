<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable=[
        'id',
        'nombre',
        'nit',
        'direccion',
        'telefonos',
        'tipo_proveedor_id'
        ];


    public function tipo_proveedor(){
        return $this->belongsTo(TipoProveedor::class);
    }
    public function mantto_equipo(){
        return $this->hasMany(MantenimientoEquipo::class);
    }
}
