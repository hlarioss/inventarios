<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedEstadoVentaTable extends Migration
{
    public function up()
    {
        DB::table('estado_venta')->insert(
            array(
                array('edo_venta' => 'Realizada'),
                array('edo_venta' => 'Anulada'),
                array('edo_venta' => 'Eliminada'),
                array('edo_venta' => 'Cierre'),
                )
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('estado_venta')->delete();
    }
}