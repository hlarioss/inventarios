<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVentasDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_detalle', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('venta_id')->unsigned()->nullable();
            $table->foreign('venta_id')->references('id')->on('ventas_maestro')->onDelete('cascade');

            $table->integer('producto_id')->unsigned()->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            
            $table->integer('servicio_id')->unsigned()->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->integer('movimiento_producto_id')->unsigned()->nullable();
            
            $table->integer('precio_id')->unsigned()->nullable();
            $table->foreign('precio_id')->references('id')->on('precios_producto')->onDelete('cascade');


            $table->text('detalle_mano_obra');
            $table->integer('cantidad');
            $table->float('precio_compra')->nullable();
            $table->float('precio_venta');
            $table->float('subtotal');
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
        Schema::drop('ventas_detalle');
    }
}
