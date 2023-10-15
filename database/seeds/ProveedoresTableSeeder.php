<?php

use Illuminate\Database\Seeder;
use App\Proveedor;

class ProveedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::truncate();

        $proveedor = new Proveedor;
        $proveedor->nombre= "Mecanico";
        $proveedor->direccion="2500";
        $proveedor->nit="364853-2";
        $proveedor->telefonos="79451161";
        $proveedor->tipo_proveedor_id="1";

        $proveedor->save();
    }
}
