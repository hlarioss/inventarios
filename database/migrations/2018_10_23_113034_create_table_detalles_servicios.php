<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetallesServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('producto_id')->nullable();
            $table->unsignedInteger('servicio_id');
            $table->unsignedInteger('maquinaria_equipo_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->float('costo')->nullable();
            $table->float('cantidad')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->foreign('maquinaria_equipo_id')->references('id')->on('maquinarias_y_equipos')->onDelete('cascade');
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
        Schema::drop('detalles_servicios');
    }
}
