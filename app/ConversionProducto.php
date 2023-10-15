<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversionProducto extends Model
{
    protected $table = 'conversiones_productos';

    protected $fillable=[
        'id',
        'user_id',
        'fecha'
        ];


    public function detalles_conversiones(){
        return $this->hasMany(DetalleConversion::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
