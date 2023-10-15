<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateTableDetallesCuentasPorPagar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_cuentas_por_pagar', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('compra_id')->nullable();
            $table->unsignedInteger('cuenta_por_pagar_id');
            $table->string('num_factura')->nullable();
            $table->date('fecha');
            $table->string('descripcion');
            $table->float('cargos')->nullable();
            $table->float('abonos')->nullable();
            $table->float('saldo')->nullable();

            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
            $table->foreign('cuenta_por_pagar_id')->references('id')->on('cuentas_por_pagar')->onDelete('cascade');
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
        Schema::drop('detalles_cuentas_por_pagar');
    }
}
