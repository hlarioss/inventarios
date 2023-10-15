<?php

use Illuminate\Database\Seeder;
use App\TipoVehiculo;

class TiposVehiculoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoVehiculo::truncate();

        $tipo = new TipoVehiculo;
        $tipo->nombre= "Pick-Up";
        $tipo->save();

        $tipo = new TipoVehiculo;
        $tipo->nombre= "Sedan";
        $tipo->save();

        $tipo = new TipoVehiculo;
        $tipo->nombre= "Camion";
        $tipo->save();
    }
}
