<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('nit',20)->unique()->nullable();
            $table->string('dpi', 30)->unique()->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefonos',30)->nullable();
            $table->string('email')->nullable();
            $table->integer('record_compra')->nullable();
            $table->unsignedInteger('tipo_cliente_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('clasificacion_cliente_id')->nullable();

            $table->foreign('clasificacion_cliente_id')->references('id')->on('clasificaciones_cliente')->onDelete('cascade');
            $table->foreign('tipo_cliente_id')->references('id')->on('tipos_cliente')->onDelete('cascade');
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
        Schema::drop('clientes');
    }
}
