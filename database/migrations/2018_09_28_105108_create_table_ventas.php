<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_maestro', function($table)
        {
            $table->increments('id');
            $table->boolean('tipo_venta_id');
            
            $table->integer('tipo_pago_id')->unsigned()->nullable();
            $table->foreign('tipo_pago_id')->references('id')->on('tipos_pago')->onDelete('cascade');

            $table->float('total_venta');
            $table->integer('cliente_id')->unsigned()->nullable()->default(1);
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            
            
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('edo_venta_id')->unsigned()->nullable();
            $table->foreign('edo_venta_id')->references('id')->on('estado_venta')->onDelete('cascade');

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
        Schema::drop('ventas_maestro');
    }
}