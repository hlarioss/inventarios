<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUnidadesDeMedida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades_de_medida', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->float('cantidad');
            $table->unsignedInteger('unidad_de_medida_id')->nullable();
            $table->foreign('unidad_de_medida_id')->references('id')->on('unidades_de_medida')->onDelete('cascade');
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
        Schema::drop('unidades_de_medida');
    }
}
