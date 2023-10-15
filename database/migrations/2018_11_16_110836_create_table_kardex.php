<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKardex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('transaccion')->nullable;
            $table->unsignedInteger('producto_id');
            $table->float('ingreso');
            $table->float('salida');
            $table->float('existencia_anterior');
            $table->float('saldo');
            
            $table->float('costo');//precio de compra
            $table->float('costo_ponderado')->nullable();
            $table->float('costo_entrada')->nullable();
            $table->float('costo_salida')->nullable();
            $table->float('costo_anterior')->nullable();
            $table->float('costo_acumulado')->nullable();
            $table->integer('venta_id')->unsigned()->nullable();
            

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('venta_id')->references('id')->on('ventas_maestro')->onDelete('cascade');
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
        Schema::drop('kardex');
    }
}
