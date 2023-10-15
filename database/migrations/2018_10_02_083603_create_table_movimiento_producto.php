<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMovimientoProducto extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_productos', function($table)
        {
            $table->increments('id');
            $table->date('fecha_ingreso');
            
            $table->integer('producto_id')->unsigned()->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->integer('maquinaria_equipo_id')->unsigned()->nullable();
            $table->foreign('maquinaria_equipo_id')->references('id')->on('maquinarias_y_equipos')->onDelete('cascade');
            $table->integer('paquete');
            $table->integer('existencias');
            $table->float('precio_compra');
            $table->float('precio_venta')->nullable();
            $table->boolean('vendido')->nullable()->default(0);

            //campos para controlar inserts y updates
            //created_at updated_at
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
        Schema::drop('movimientos_productos');
    }
}
