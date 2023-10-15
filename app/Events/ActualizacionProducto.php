<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;

class ActualizacionProducto extends Event
{
    public $producto;
    public $transaccion;
    public $ingreso;
    public $salida;
    public $existencia_anterior;

    use SerializesModels; 

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($producto, $transaccion, $ingreso, $salida, $existencia_anterior, $saldo, $costo , $costo_ponderado, $costo_entrada, $costo_salida, $costo_anterior, $costo_acumulado)
    {
        $this->producto = $producto;
        $this->transaccion = $transaccion;
        $this->ingreso = $ingreso;
        $this->salida = $salida;
        $this->existencia_anterior = $existencia_anterior;
        $this->saldo = $saldo;
        $this->costo = $costo;
        $this->costo_ponderado = $costo_ponderado;
        $this->costo_entrada = $costo_entrada;
        $this->costo_salida = $costo_salida;
        $this->costo_anterior = $costo_anterior;
        $this->costo_acumulado = $costo_acumulado;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
