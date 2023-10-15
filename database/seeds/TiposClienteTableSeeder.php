<?php

use Illuminate\Database\Seeder;
use App\TipoCliente;

class TiposClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCliente::truncate();

        $tc = new TipoCliente;
        $tc->nombre= "Tipo C";
        $tc->descuento="0";
        $tc->save();

        $tc = new TipoCliente;
        $tc->nombre= "Tipo B";
        $tc->descuento="5";
        $tc->save();

        $tc = new TipoCliente;
        $tc->nombre= "Tipo A";
        $tc->descuento="10";
        $tc->save();
        
    }
}
