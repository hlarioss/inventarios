<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRayones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rayones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('orden_id')->nullable();
            $table->boolean('img1_1')->nullable()->default('0');
            $table->boolean('img1_2')->nullable()->default('0');
            $table->boolean('img1_3')->nullable()->default('0');
            $table->boolean('img1_4')->nullable()->default('0');
            $table->boolean('img1_5')->nullable()->default('0');
            $table->boolean('img1_6')->nullable()->default('0');
            $table->boolean('img1_7')->nullable()->default('0');
            $table->boolean('img1_8')->nullable()->default('0');
            $table->boolean('img1_9')->nullable()->default('0');
            $table->boolean('img1_10')->nullable()->default('0');
            $table->boolean('img1_11')->nullable()->default('0');
            $table->boolean('img1_12')->nullable()->default('0');
            
            $table->boolean('img2_1')->nullable()->default('0');
            $table->boolean('img2_2')->nullable()->default('0');
            $table->boolean('img2_3')->nullable()->default('0');
            $table->boolean('img2_4')->nullable()->default('0');
            $table->boolean('img2_5')->nullable()->default('0');
            $table->boolean('img2_6')->nullable()->default('0');
            
            $table->boolean('img3_1')->nullable()->default('0');
            $table->boolean('img3_2')->nullable()->default('0');
            $table->boolean('img3_3')->nullable()->default('0');
            $table->boolean('img3_4')->nullable()->default('0');
            $table->boolean('img3_5')->nullable()->default('0');
            $table->boolean('img3_6')->nullable()->default('0');

            $table->boolean('img4_1')->nullable()->default('0');
            $table->boolean('img4_2')->nullable()->default('0');
            $table->boolean('img4_3')->nullable()->default('0');
            $table->boolean('img4_4')->nullable()->default('0');
            $table->boolean('img4_5')->nullable()->default('0');
            $table->boolean('img4_6')->nullable()->default('0');
            $table->text('descripcion')->nullable();
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
        Schema::drop('rayones');
    }
}
