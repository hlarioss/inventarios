<?php

use Illuminate\Database\Seeder;

use App\TipoProveedor;

class TiposProveedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoProveedor::truncate();

        $tipo = new TipoProveedor;
        $tipo->nombre= "Individual";
        $tipo->save();

        $tipo2 = new TipoProveedor;
        $tipo2->nombre= "Empresa";
        $tipo2->save();
    }
}
