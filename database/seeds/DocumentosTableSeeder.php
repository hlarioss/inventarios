<?php

use Illuminate\Database\Seeder;
use App\Documento;
class DocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Documento::truncate();
        
        $documento = new Documento;
        $documento->descripcion= "Factura";
        $documento->save();
        
        $documento = new Documento;
        $documento->descripcion= "Recibo de Caja";
        $documento->save();
        
        $documento = new Documento;
        $documento->descripcion= "Nota de Débito";
        $documento->save();
        
        $documento = new Documento;
        $documento->descripcion= "Factura Cambiaria";
        $documento->save();
        
        $documento = new Documento;
        $documento->descripcion= "Vale";
        $documento->save();
        
        
    }
}
