<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProveedor extends Model
{
    protected $table = 'tipos_proveedor';
    protected $fillable=[
        'id', 'nombre'
    ];

    public function proveedores(){
        return $this->hasMany(Proveedor::class);
       }
    
}
