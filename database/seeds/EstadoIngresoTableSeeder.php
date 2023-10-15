<?php

use Illuminate\Database\Seeder;
use App\EstadoIngreso;

class EstadoIngresoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoIngreso::truncate();
        
        $estado = new EstadoIngreso;
        $estado->edo_ingreso= "Activo";
        $estado->save();
        
        $estado = new EstadoIngreso;
        $estado->edo_ingreso= "Anulado";
        $estado->save();

        $estado = new EstadoIngreso;
        $estado->edo_ingreso= "Eliminado";
        $estado->save();
    }
}
