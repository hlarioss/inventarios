<?php

use Illuminate\Database\Seeder;
use App\TipoPago;

class TiposPagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPago::truncate();

        $tipopago = new TipoPago;
        $tipopago->tipo_pago= "Efectivo";
        $tipopago->save();
        
        $tipopago = new TipoPago;
        $tipopago->tipo_pago= "Tarjeta";
        $tipopago->save();

        $tipopago = new TipoPago;
        $tipopago->tipo_pago= "Credito";
        $tipopago->save();

    }
}