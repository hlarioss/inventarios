<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTiposCajaTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
       DB::table('tipos_caja')->insert(
           array(
               array('tipo_caja' => 'Secuencial'),
               array('tipo_caja' => 'CBT'),
               array('tipo_caja' => 'Mécaninca'),
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
