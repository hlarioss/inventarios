<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedColoresTable extends Migration
{
         /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('colores')->insert(
            array(
                array('color' => 'Antracita'),
                array('color' => 'Arena Tayrona'),
                array('color' => 'Azul Abisal'),
                array('color' => 'Azul Cian'),
                array('color' => 'Azul Eléctrico'),
                array('color' => 'Azul Fashion'),
                array('color' => 'Azul Grisáceo'),
                array('color' => 'Azul Kallfu'),
                array('color' => 'Azul Kanbe'),
                array('color' => 'Azul Shark'),
                array('color' => 'Azul Zafiro'),
                array('color' => 'Beige'),
                array('color' => 'Blanco Perlado'),
                array('color' => 'Blanco Classic'),
                array('color' => 'Blanco Gorobe'),
                array('color' => 'Blanco Nieve Classic'),
                array('color' => 'Blanco Glaciar'),
                array('color' => 'Bronce'),
                array('color' => 'Burdeos'),
                array('color' => 'Burdeos Diamond Mica'),
                array('color' => 'Granate'),
                array('color' => 'Gris Grafito'),
                array('color' => 'Gris Oscuro Kikuchiyo'),
                array('color' => 'Gris Pizarra'),
                array('color' => 'Gris Platino'),
                array('color' => 'Gris Plomo'),
                array('color' => 'Naranja Heihachi'),
                array('color' => 'Negro Azabache'),
                array('color' => 'Negro Classic'),
                array('color' => 'Negro Frac'),
                array('color' => 'Negro Shichiroyi'),
                array('color' => 'Plata'),
                array('color' => 'Plata Katshushiro'),
                array('color' => 'Rojo'),
                array('color' => 'Rojo Classic'),
                array('color' => 'Rojo Rubí'),
                array('color' => 'Terracota'),
                array('color' => 'Turquesa Egeo'),
                array('color' => 'Verde Old Mine'),
                array('color' => 'Verde Oliva'),       
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
        DB::table('colores')->delete();
    }
}
