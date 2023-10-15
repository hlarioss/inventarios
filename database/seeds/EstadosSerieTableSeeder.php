<?php

use Illuminate\Database\Seeder;
use App\EstadoSerie;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoSerie::truncate();

        $estado = new EstadoSerie;
        $estado->estado= "Creado";
        $estado->save();
        
        $estado = new EstadoSerie;
        $estado->estado= "Activo";
        $estado->save();
        
        $estado = new EstadoSerie;
        $estado->estado= "Finalizado";
        $estado->save();

        $estado = new EstadoSerie;
        $estado->estado= "Vencido";
        $estado->save();
        
        $estado = new EstadoSerie;
        $estado->estado= "Anulado";
        $estado->save();
    }
}
