<?php

use Illuminate\Database\Seeder;
use App\Puesto;

class PuestosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Puesto::truncate();

        $puesto = new Puesto;
        $puesto->nombre= "Mecanico";
        $puesto->sueldo="2500";
        $puesto->save();

        $puesto = new Puesto;
        $puesto->nombre= "Cajero";
        $puesto->sueldo="3000";
        $puesto->save();
    }
}
