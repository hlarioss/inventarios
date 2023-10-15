<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetallesConversiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_conversiones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('producto_id_ingresa');
            $table->unsignedInteger('producto_id_sale');
            $table->unsignedInteger('conversion_producto_id');
            $table->unsignedInteger('movimiento_producto_id');

            $table->foreign('movimiento_producto_id')->references('id')->on('movimientos_productos')->onDelete('cascade');
            $table->foreign('producto_id_ingresa')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('producto_id_sale')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('conversion_producto_id')->references('id')->on('conversiones_productos')->onDelete('cascade');
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
        Schema::drop('detalles_conversiones');
    }
}
