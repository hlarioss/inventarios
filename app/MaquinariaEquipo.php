<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaquinariaEquipo extends Model
{
    protected $table ='maquinarias_y_equipos';

    protected $fillable=[
        'id',
        'nombre_maquina',
        'codigo_maquina',
        'marca',
        'labadas_limite',
        'fecha_adquisicion',
        'descripcion',
        'localidad_id'
        ];
    public function mantto_equipo(){
        return $this->hasMany(MantenimientoEquipo::class);
    }
    public function marcas(){
        return $this->belongsTo(Marca::class);
    }
    public function localidades(){
        return $this->belongsTo(Localidad::class);
    }
    public function detalles_servicios(){
        return $this->hasMany(DetalleServicio::class);
    }
    public function detalles_compras(){
        return $this->hasMany(DetalleCompra::class);
    }
}
