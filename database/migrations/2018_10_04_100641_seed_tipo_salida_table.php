<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTipoSalidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tipos_salida')->insert(
            array(
                array('tipo_salida' => 'Por Venta'),
                array('tipo_salida' => 'Por Vencimiento'),
                array('tipo_salida' => 'Golpeado/Quebrado'),
                array('tipo_salida' => 'Por Devolución'),
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
        DB::table('tipos_salida')->delete();
    }
}
