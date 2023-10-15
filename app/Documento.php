<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable=[
        'id',
        'descripcion'
        ];
    public function series(){
        return $this->hasMany(Series::class);
    }
}
