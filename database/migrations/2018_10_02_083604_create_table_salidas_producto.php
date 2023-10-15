<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSalidasProducto extends Migration
{
 /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas_productos', function($table)
        {
            $table->increments('id');

            $table->date('fecha_salida');
            $table->unsignedInteger('producto_id');
            $table->unsignedInteger('user_id');
            $table->float('cantidad_salida');
            $table->unsignedInteger('movimiento_producto_id');
            $table->unsignedInteger('tipo_salida_id');
            

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('movimiento_producto_id')->references('id')->on('movimientos_productos')->onDelete('cascade');
            $table->foreign('tipo_salida_id')->references('id')->on('tipos_salida')->onDelete('cascade');
            
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
        Schema::drop('salidas_productos');
    }
}
