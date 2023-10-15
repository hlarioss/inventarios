<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaquinariaEquipoServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquinaria_equipo_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('servicio_id');
            $table->unsignedInteger('maquinaria_equipo_id');

            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->foreign('maquinaria_equipo_id')->references('id')->on('maquinarias_y_equipos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('maquinaria_equipo_servicio');
    }
}
