@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($ingreso_producto, ['method' => 'PATCH', 'action' => ['IngresosProductoController@update', $ingreso_producto->id], 'id' => 'IngresoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Ingreso </h3>
            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-sm-4">
                {!! Form::label("cantidad","Cantidad:") !!}
                {!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
            </div>

            <div class="col-sm-4">
                {!! Form::label("precio_compra","Precio Compra:") !!}
                {!! Form::text( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Compra' ]) !!}
            </div>

            <div class="col-sm-4">
                    {!! Form::label("precio_venta","Precio Venta:") !!}
                    {!! Form::text( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio venta' ]) !!}
                </div>
        </div>
        <br>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ingresos_productos') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateIngreso']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/ingresos_productos/edit.js') !!}
@endsection
