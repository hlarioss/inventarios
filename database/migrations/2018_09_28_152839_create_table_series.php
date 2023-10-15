<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resolucion')->primary_key();
            $table->string('serie');     
            $table->date('fecha_resolucion');
            $table->date('fecha_vencimiento');
            $table->integer('inicio');
            $table->integer('fin');
            $table->unsignedInteger('estado_id')->default(1)->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('documento_id');

            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
            $table->foreign('estado_id')->references('id')->on('estados_serie')->onDelete('cascade');
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
        Schema::drop('series');
    }
}
