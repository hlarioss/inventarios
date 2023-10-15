@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($tipo_vehiculo, ['method' => 'PATCH', 'action' => ['TiposVehiculoController@update', $tipo_vehiculo->id], 'id' => 'TipoVehiculoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Tipo de Vehiculo </h3>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-sm-4">
                    {!! Form::label("nombre","Tipo de Vehiculo:") !!}
                    {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Tipo de Vehiculo' ]) !!}
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/tipos_vehiculo') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateTipoVehiculo']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/tipos_vehiculo/edit.js') !!}
@endsection