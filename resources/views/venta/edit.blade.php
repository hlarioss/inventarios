@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($venta, ['method' => 'PATCH', 'action' => ['VentasController@update', $venta->id], 'id' => 'VentaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Venta </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("cliente_id","Cliente:") !!}
                <select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($clientes as $cliente)
                    @if ( $cliente->id == $venta->cliente_id)
                    <option value="{{$cliente->id}}" selected>{{ $cliente->nombres}} {{ $cliente->apellidos}}</option>
                    @else
                    <option value="{{$cliente->id}}">{{ $cliente->nombres}} {{ $cliente->apellidos}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("tipo_pago_id","Tipo de Pago:") !!}
                <select class="selectpicker" id='tipo_pago_id' name="tipo_pago_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipo_pagos as $tipo_pago)
                    @if ( $tipo_pago->id == $venta->tipo_pago_id)
                    <option value="{{$tipo_pago->id}}" selected>{{ $tipo_pago->tipo_pago}}</option>
                    @else
                    <option value="{{$tipo_pago->id}}">{{ $tipo_pago->tipo_pago}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ventas') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateVenta']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/venta/edit.js') !!}
@endsection
