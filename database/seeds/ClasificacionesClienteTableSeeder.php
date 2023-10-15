<?php

use Illuminate\Database\Seeder;
use App\ClasificacionCliente;

class ClasificacionesClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClasificacionCliente::truncate();

        $clasificacion = new ClasificacionCliente;
        $clasificacion->nombre= "Individual";
        $clasificacion->save();

        $clasificacion = new ClasificacionCliente;
        $clasificacion->nombre= "Empresa";
        $clasificacion->save();
    }
}
