<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdenesDeTrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes_de_trabajo', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha_hora');
            $table->string('resp_recepcion');
            $table->date('fecha_prometida');
            $table->unsignedInteger('cliente_id');
            $table->unsignedInteger('vehiculo_id');
            $table->unsignedInteger('estado_id')->default(1);
            $table->float('total')->nullable();


            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('estado_id')->references('id')->on('estados_serie')->onDelete('cascade');
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
        Schema::drop('ordenes_de_trabajo');
    }
}
