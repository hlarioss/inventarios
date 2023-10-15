<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTipoDireccionTable extends Migration
{
         /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('direccion')->insert(
            array(
                array('tipo_direccion' => 'Asistida'),
                array('tipo_direccion' => 'Hidráulica'),
                array('tipo_direccion' => 'Mecánica'),
                
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
        DB::table('direccion')->delete();
    }
}
