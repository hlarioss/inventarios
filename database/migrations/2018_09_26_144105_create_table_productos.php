<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('codigo_barra',20);
            $table->float('minimo');

            $table->unsignedInteger('medida_id');
            $table->foreign('medida_id')->references('id')->on('unidades_de_medida')->onDelete('cascade');

            $table->unsignedInteger('marca_id');
            
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');
            $table->text('descripcion');

            $table->unsignedInteger('localidad_id');
            $table->foreign('localidad_id')->references('id')->on('localidades')->onDelete('cascade');


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
        Schema::drop('productos');
    }
}
