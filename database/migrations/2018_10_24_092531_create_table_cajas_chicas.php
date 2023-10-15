<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\CajaChica;

class CreateTableCajasChicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas_chicas', function (Blueprint $table) {
            $table->increments('id');
            $table->float('saldo');

            $table->timestamps();
        });

        CajaChica::truncate();

        DB::table('cajas_chicas')->insert(
            array(
                array('saldo' => 0),                
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
        Schema::drop('cajas_chicas');
    }
}
