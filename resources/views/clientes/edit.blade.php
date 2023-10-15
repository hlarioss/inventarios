@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($cliente, ['method' => 'PATCH', 'action' => ['ClientesController@update', $cliente->id], 'id' => 'ClienteUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Clientes </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3 form-group {{$errors->has('nit')? 'has-error' : ''}}">
                {!! Form::label("nit","NIT:") !!}
                {!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
                {!!$errors->first('nit', '<label class="error">:message</label>')!!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("email","e-mail:") !!}
                {!! Form::text( "email" , null , ['class' => 'form-control' , 'placeholder' => 'e-mail' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("tipo_cliente_id","Tipo de Cliente:") !!}
                <select class="selectpicker" id='tipo_cliente_id' name="tipo_cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_clientes as $tipo_cliente)
                    @if ( $tipo_cliente->id == $cliente->tipo_cliente_id)
                    <option value="{{$tipo_cliente->id}}" selected>{{ $tipo_cliente->nombre}}</option>
                    @else
                    <option value="{{$tipo_cliente->id}}">{{ $tipo_cliente->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("clasificacion_cliente_id","Clasificacion:") !!}
                <select class="selectpicker" id='clasificacion_cliente_id' name="clasificacion_cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($clasificaciones as $clasificacion)
                    @if ( $clasificacion->id == $cliente->clasificacion_cliente_id)
                    <option value="{{$clasificacion->id}}" selected>{{ $clasificacion->nombre}}</option>
                    @else
                    <option value="{{$clasificacion->id}}">{{ $clasificacion->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4 form-group {{$errors->has('dpi')? 'has-error' : ''}}">
                {!! Form::label("dpi","DPI/CUI:") !!}
                {!! Form::text( "dpi" , null , ['class' => 'form-control' , 'placeholder' => 'DPI/CUI' ]) !!}
                {!!$errors->first('dpi', '<label class="error">:message</label>')!!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("nombres","Nombres:") !!}
                {!! Form::text( "nombres" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("apellidos","Apellidos:") !!}
                {!! Form::text( "apellidos" , null , ['class' => 'form-control' , 'placeholder' => 'Apellidos' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("fecha_nacimiento","Fecha Nacimiento:") !!}
                {!! Form::date( "fecha_nacimiento" , null , ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("telefonos","Teléfono:") !!}
                {!! Form::text( "telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Telefonos' ]) !!}
            </div>
            <div class="col-sm-5">
                {!! Form::label("direccion","Dirección:") !!}
                {!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/clientes') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateCliente']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/clientes/edit.js') !!}
@endsection