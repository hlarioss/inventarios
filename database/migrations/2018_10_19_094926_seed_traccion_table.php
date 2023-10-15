<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTraccionTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tracciones')->insert(
            array(
                array('traccion' => 'Sencilla'),
                array('traccion' => 'Doble'),
                array('traccion' => '4*2'),
                array('traccion' => '4*4'),
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
        DB::table('tracciones')->delete();
    }
}
