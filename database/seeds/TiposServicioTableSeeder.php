<?php

use Illuminate\Database\Seeder;
use App\TipoServicio;

class TiposServicioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoServicio::truncate();

        $tipo = new TipoServicio;
        $tipo->nombre= "Lavada";
        $tipo->save();

        $tipo = new TipoServicio;
        $tipo->nombre= "Detailing";
        $tipo->save();

        $tipo = new TipoServicio;
        $tipo->nombre= "Lubricentro";
        $tipo->save();

        $tipo = new TipoServicio;
        $tipo->nombre= "Frenos";
        $tipo->save();

    }
}
