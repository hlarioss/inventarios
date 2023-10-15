@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($venta_detalle, ['method' => 'PATCH', 'action' => ['VentasController@updateDetalle', $venta_detalle->id], 'id' => 'DetalleUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Detalle de Venta </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                @if($venta_detalle->servicio_id)
                {!! Form::label("servicio_id","servicio:") !!}
                <select class="selectpicker" id='servicio_id',disabled ,  name="servicio_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($servicios as $servicio)
                    @if($servicio->id == $venta_detalle->servicio_id)
                    <option value="{{$servicio->id}}" selected>{{$servicio->nombre}}</option>
                     @endif							
                    @endforeach
                </select>
                @elseif($venta_detalle->producto_id)
                {!! Form::label("producto_id","Producto:") !!}
                <select class="selectpicker" ,disabled ,  id='producto_id', name="producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($productos as $producto)
                    @if($producto->id == $venta_detalle->producto_id)
                    <option value="{{$producto->id}}" selected>{{$producto->nombre}}</option>
                    @endif							
                    @endforeach
                </select>
                @else
                {!! Form::label("Mano de obra","Mano de obra:") !!}
                {!! Form::text( "detalle_mano_obra" , null , ['class' => 'form-control' , 'placeholder' => 'nombre' ]) !!}
                @endif
            </div>
            <div class="col-sm-3">
                {!! Form::label("precio_venta","Precio Venta:") !!}
                {!! Form::number( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Venta' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("cantidad","Cantidad:") !!}
                {!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
            </div>
           
            
        </div>
        <br>
        <div class="row" >
            <div class="col-sm-3">
                {!! Form::label("subtotal_venta","Subtotal:") !!}
                {!! Form::text( "subtotal_venta" , $venta_detalle->precio_venta * $venta_detalle->cantidad , ['class' => 'form-control' , 'placeholder' => 'Cantidad', 'disabled' => 'true' ]) !!}
            </div>
        </div>
        <br>
        @if($venta_detalle->producto_id)
            {!! Form::hidden("cantidad_ant" , $venta_detalle->cantidad , ['class' => 'form-control' , 'disabled']) !!}
            {!! Form::hidden("existencias" , $movimientos , ['class' => 'form-control' , 'disabled']) !!}
            <div id='total_existencia', name="existencias" style="font-size:16px; font-weight:bold; color:green"> La existencia del producto con el precio Q.  {{$venta_detalle->precio_venta}}  es de: {{$movimientos}} </div>
        @endif
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ventas') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateDetalle']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/venta/editdetalle.js') !!}
@endsection