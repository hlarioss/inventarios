@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($tipo_cliente, ['method' => 'PATCH', 'action' => ['TiposClienteController@update', $tipo_cliente->id], 'id' => 'TipoClienteUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Tipo de Cliente </h3>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-sm-4">
                    {!! Form::label("nombre","Tipo de Cliente:") !!}
                    {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Tipo de Cliente' ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label("descuento","Porcentaje de descuento:") !!}
                    {!! Form::number( "descuento" , null , ['class' => 'form-control' , 'placeholder' => 'Porcentaje de descuento' ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label("monto_mensual","Monto mensual:") !!}
                    {!! Form::number( "monto_mensual" , null , ['class' => 'form-control' , 'placeholder' => 'Monto mensual' ]) !!}
                </div>
            </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/tipos_cliente') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateTipoCliente']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/tipos_cliente/edit.js') !!}
@endsection