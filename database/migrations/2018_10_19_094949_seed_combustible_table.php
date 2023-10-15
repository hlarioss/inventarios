<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCombustibleTable extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('combustible')->insert(
            array(
                array('combustible' => 'Gasolina'),
                array('combustible' => 'Diesel'),
              
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
        DB::table('combustible')->delete();
    }
}
