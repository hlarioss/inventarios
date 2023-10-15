<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedClienteTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
       DB::table('clientes')->insert(
           array(
               array('nombres' => 'Consumidor','apellidos' => 'Final','nit' => 'C/F','direccion' => 'Ciudad'),
               )
           );
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
       DB::table('tipos_caja')->delete();
   }
}