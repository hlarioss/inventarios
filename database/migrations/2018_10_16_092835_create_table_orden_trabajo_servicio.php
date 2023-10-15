<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrdenTrabajoServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_trabajo_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('servicio_id');
            $table->unsignedInteger('orden_de_trabajo_id');
            $table->float('mano_obra');

            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->foreign('orden_de_trabajo_id')->references('id')->on('ordenes_de_trabajo')->onDelete('cascade');
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
        Schema::drop('orden_trabajo_servicio');
    }
}
