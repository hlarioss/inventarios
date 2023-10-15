<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Golpe extends Model
{
    protected $table = 'golpes';

    protected $fillable=[
        'img1_1',
        'img1_2',
        'img1_3',
        'img1_4',
        'img1_5',
        'img1_6',
        'img1_7',
        'img1_8',
        'img1_9',
        'img1_10',
        'img1_11',
        'img1_12',
        'img2_1',
        'img2_2',
        'img2_3',
        'img2_4',
        'img2_5',
        'img2_6',
        'img3_1',
        'img3_2',
        'img3_3',
        'img3_4',
        'img3_5',
        'img3_6',
        'img4_1',
        'img4_2',
        'img4_3',
        'img4_4',
        'img4_5',
        'img4_6',
        'orden_id',
        'id'
        
    ];

    public function orden_trabajo(){
        return $this->belongsTo(OrdenDeTrabajo::class);
    }

}
