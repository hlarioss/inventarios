<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetallesCajasChicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_cajas_chicas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('documento', 30);
            $table->string('descripcion', 100);
            $table->unsignedInteger('caja_chica_id');
            $table->unsignedInteger('user_id');
            $table->float('gasto');
            $table->float('ingreso');
            $table->float('saldo');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('caja_chica_id')->references('id')->on('cajas_chicas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('detalles_cajas_chicas');
    }
}
