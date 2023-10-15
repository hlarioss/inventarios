<?php

namespace App\Listeners;

use App\Events\ActualizacionProducto;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Kardex;
use Carbon\Carbon;

class RegistrarKardex
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActualizacionProducto  $event
     * @return void
     */
    public function handle(ActualizacionProducto $event)
    {
        $kardex = new Kardex;
        $kardex->fecha = carbon::now();
        $kardex->transaccion = $event->transaccion;
        $kardex->producto_id = $event->producto;
        $kardex->ingreso = $event->ingreso;
        $kardex->salida = $event->salida;
        $kardex->existencia_anterior =  $event->existencia_anterior;
        $kardex->saldo = $event->saldo;
        $kardex->costo = $event->costo;
        $kardex->costo_ponderado = $event->costo_ponderado;
        $kardex->costo_entrada = $event->costo_entrada;
        $kardex->costo_salida = $event->costo_salida;
        $kardex->costo_anterior = $event->costo_anterior;
        $kardex->costo_acumulado = $event->costo_acumulado;
        $kardex->save();
    }
}
