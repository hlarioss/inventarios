<?php

use Illuminate\Database\Seeder;
use App\TipoMarca;
Use App\Marca;

class TiposMarcaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMarca::truncate();
        Marca::truncate();

        $tipo = new TipoMarca;
        $tipo->nombre= "General";
        $tipo->save();

        $tipo = new TipoMarca;
        $tipo->nombre= "Vehiculo";
        $tipo->save();

        $tipo = new TipoMarca;
        $tipo->nombre= "Producto";
        $tipo->save();
        
        $tipo = new TipoMarca;
        $tipo->nombre= "Maquinaria";
        $tipo->save();

        $marca = new Marca;
        $marca->nombre = "Fritolay";
        $marca->tipo_marca_id = "3";
        $marca->save();

        $marca = new Marca;
        $marca->nombre = "Coca Cola";
        $marca->tipo_marca_id = "3";
        $marca->save();

        $marca = new Marca;
        $marca->nombre = "Komatsu";
        $marca->tipo_marca_id = "4";
        $marca->save();

        $marca = new Marca;
        $marca->nombre = "Hitachi";
        $marca->tipo_marca_id = "4";
        $marca->save();

        $marca = new Marca;
        $marca->nombre = "Toyota";
        $marca->tipo_marca_id = "2";
        $marca->save();

    }
}
