<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaquinariaEquipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquinarias_y_equipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_maquina');
            $table->string('codigo_maquina',20)->nullable();

            $table->unsignedInteger('marca');
            $table->foreign('marca')->references('id')->on('marcas')->onDelete('cascade');

            $table->integer('labadas_limite')->nullable();
            $table->date('fecha_adquisicion');
            $table->text('descripcion') ->nullable();
            
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
        Schema::drop('maquinarias_y_equipos');
    }
}
