<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('id');
           /* parte vehiculos*/ 
            $table->string('placa');
            $table->unsignedInteger('tipo_vehiculo_id');
            $table->unsignedInteger('marca_id');
            $table->unsignedInteger('linea_id');
            $table->float('kilometraje');
            $table->integer('anio');
            $table->unsignedInteger('color_id');
            $table->date('fecha_ultimo_servicio');
            $table->string('vin')->nullable();
            $table->unsignedInteger('cliente_id');
            $table->unsignedInteger('direccion_id');
            /* parte Transmision*/
            $table->unsignedInteger('transmision_id');
            $table->unsignedInteger('traccion_id');
            $table->string('diferenciales');
            $table->unsignedInteger('tipo_caja_id');
            $table->string('aceite_caja_fabrica');
            $table->string('aceite_caja');
            $table->string('cantidad_aceite_caja');
            $table->string('viscosidad_caja');
            
            
            /*Parte Motor */
            $table->unsignedInteger('combustible_id');
            $table->string('no_motor');
            $table->string('ccs');
            $table->string('cilindros');
            $table->string('aceite_motor_fabrica');
            $table->string('aceite_motor');
            $table->string('cantidad_aceite_motor');
            $table->string('viscosidad_motor');
            $table->string('observaciones');
            
            $table->foreign('tipo_vehiculo_id')->references('id')->on('tipos_vehiculo')->onDelete('cascade');
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');
            $table->foreign('linea_id')->references('id')->on('linea')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colores')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('direccion_id')->references('id')->on('direccion')->onDelete('cascade');

            $table->foreign('transmision_id')->references('id')->on('transmision')->onDelete('cascade');
            $table->foreign('traccion_id')->references('id')->on('tracciones')->onDelete('cascade');
            $table->foreign('tipo_caja_id')->references('id')->on('tipos_caja')->onDelete('cascade');
            
            $table->foreign('combustible_id')->references('id')->on('combustible')->onDelete('cascade');
            
           
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
        Schema::drop('vehiculos');
    }
}
