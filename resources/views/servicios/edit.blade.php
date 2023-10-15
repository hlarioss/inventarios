@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($servicio, ['method' => 'PATCH', 'action' => ['ServiciosController@update', $servicio->id], 'id' => 'ServicioUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de servicio </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-2">
                {!! Form::label("tipo_servicio_id","Tipo de Servicio:") !!}
                <select class="selectpicker" id='tipo_servicio_id' name="tipo_servicio_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_servicio as $tipo_servicio)
                    @if($tipo_servicio->id == $servicio->tipo_servicio_id)
                    <option value="{{$tipo_servicio->id}}" selected>{{$tipo_servicio->nombre}}</option>
                    @else
                    <option value="{{$tipo_servicio->id}}">{{$tipo_servicio->nombre}}</option>
                    @endif							
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                {!! Form::label("codigo","Codigo Interno:") !!}
                {!! Form::text( "codigo" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo de servicio' ]) !!}
            </div>
            <div class="col-sm-8">
                {!! Form::label("nombre","Nombre Servicio:") !!}
                {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre servicio' ]) !!}
            </div>
            
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("precio_costo","Precio Costo sin Mano de Obra:") !!}
                {!! Form::number( "precio_costo" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Costo sin Mano de Obra' ]) !!}

            </div>
            <div class="col-sm-4">
                {!! Form::label("precio","Precio Venta sin Mano de Obra:") !!}
                {!! Form::number( "precio" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Venta sin Mano de Obra' ]) !!}

            </div>

        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/servicios') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateServicio']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/servicios/edit.js') !!}
@endsection