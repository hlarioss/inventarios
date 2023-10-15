<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_factura');
            $table->float('total_factura');
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('user_id');
            $table->string('serie_factura');
            $table->string('num_factura');
            $table->unsignedInteger('edo_ingreso_id');
            $table->unsignedInteger('tipo_pago_id');

            $table->foreign('tipo_pago_id')->references('id')->on('tipos_pago')->onDelete('cascade');
            $table->foreign('edo_ingreso_id')->references('id')->on('estado_ingresos')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('compras');
    }
}
