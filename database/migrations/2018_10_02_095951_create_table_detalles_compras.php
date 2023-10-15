<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetallesCompras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_compras', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_ingreso');
            $table->unsignedInteger('producto_id')->nullable();
            $table->unsignedInteger('compra_id');
            $table->unsignedInteger('maquinaria_equipo_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->float('precio_compra');
            $table->float('precio_venta')->nullable();
            $table->integer('existencias');
            $table->unsignedInteger('movimiento_producto_id');

            $table->foreign('movimiento_producto_id')->references('id')->on('movimientos_productos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
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
        Schema::drop('detalles_compras');
    }
}
