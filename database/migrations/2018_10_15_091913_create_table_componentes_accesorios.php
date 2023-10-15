<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComponentesAccesorios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componentes_accesorios', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('emblemas')->nullable()->default('0');
            $table->boolean('encendedor')->nullable()->default('0');
            $table->boolean('espejos')->nullable()->default('0');
            $table->boolean('antena')->nullable()->default('0');
            $table->boolean('radio')->nullable()->default('0');
            $table->boolean('llavero')->nullable()->default('0');
            $table->boolean('placas')->nullable()->default('0');
            $table->boolean('platos')->nullable()->default('0');
            $table->boolean('tapon_combustible')->nullable()->default('0');
            $table->boolean('soporte_bateria')->nullable()->default('0');    
            $table->boolean('papeles')->nullable()->default('0');
            $table->boolean('alfombras')->nullable()->default('0');
            $table->boolean('control_alarma')->nullable()->default('0');
            $table->boolean('extinguidor')->nullable()->default('0');
            $table->boolean('triangulos')->nullable()->default('0');
            $table->boolean('vidrios_electricos')->nullable()->default('0');
            $table->boolean('conos')->nullable()->default('0');
            $table->boolean('neblineras')->nullable()->default('0');
            $table->boolean('luces')->nullable()->default('0');
            $table->boolean('llanta_repuesto')->nullable()->default('0');
            $table->boolean('llave_ruedas')->nullable()->default('0');
            $table->boolean('tricket')->nullable()->default('0');
            $table->text('descripcion')->nullable();
            $table->integer('combustible')->nullable()->default('0');
            
            $table->unsignedInteger('orden_id')->nullable();
            $table->foreign('orden_id')->references('id')->on('ordenes_de_trabajo')->onDelete('cascade');
            
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
        Schema::drop('componentes_accesorios');
    }
}
