<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMantenimientoEquipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantto_equipo', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descripcion');
            $table->date('fecha_proximo_servicio')->nullable();
            $table->date('fecha_servicio');
            $table->integer('labadas_servicio')->nullable();
            $table->integer('labadas_proximo_servicio')->nullable();
            $table->unsignedInteger('maquinaria_id');
            $table->foreign('maquinaria_id')->references('id')->on('maquinarias_y_equipos')->onDelete('cascade');

            $table->unsignedInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

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
        Schema::drop('mantto_equipo');
    }
}
