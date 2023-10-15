<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCortesCaja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cortes_caja', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('factura_inicial');
            $table->string('factura_final');
            $table->float('total');
            $table->float('efectivo');
            $table->float('credito');
            $table->float('voucher');
            $table->float('totalSF');
            $table->float('efectivoSF');
            $table->float('creditoSF');
            $table->float('voucherSF');
            $table->float('total_venta');
            
            $table->unsignedInteger('user_id')->nullable();
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
        Schema::drop('cortes_caja');
    }
}
