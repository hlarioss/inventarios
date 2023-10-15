@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($salida_producto, ['method' => 'PATCH', 'action' => ['SalidaProductoController@update', $salida_producto->id], 'id' => 'SalidaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Salida </h3>
            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-sm-4">
                {!! Form::label("cantidad_salida","Cantidad:") !!}
                {!! Form::text( "cantidad_salida" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
            </div>

            <div class="col-sm-4">
                {!! Form::label("tipo_salida_id","Tipo de salida:") !!}
                <select class="selectpicker" id='tipo_salida_id' name="tipo_salida_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_salida as $tipo_salida)
                    @if ( $tipo_salida->id == $salida_producto->tipo_salida_id)
                    <option value="{{$tipo_salida->id}}" selected>{{ $tipo_salida->tipo_salida}}</option>
                    @else
                    <option value="{{$tipo_salida->id}}">{{ $tipo_salida->tipo_salida}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/salidas_productos') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateSalida']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/salidas_productos/edit.js') !!}
@endsection
