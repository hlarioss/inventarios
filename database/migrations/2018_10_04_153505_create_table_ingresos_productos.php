<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIngresosProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_productos', function($table)
        {
            $table->increments('id');
            $table->date('fecha_ingreso');
            $table->unsignedInteger('producto_id');
            $table->unsignedInteger('user_id');
            $table->float('precio_compra');
            $table->float('precio_venta');
            $table->float('cantidad');
            $table->unsignedInteger('movimiento_producto_id');

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('movimiento_producto_id')->references('id')->on('movimientos_productos')->onDelete('cascade');

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
        Schema::drop('ingresos_productos');
    }
}
