@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($manttoequipo, ['method' => 'PATCH', 'action' => ['MantenimientoEquiposController@update', $manttoequipo->id], 'id' => 'ManttoEquipoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Modificacion de Mantenimientos Realizados </h3>
            </div>
        </div>
        <br>
        <div class="row">               
            <div class="col-sm-4">
                {!! Form::label("maquinaria_id","Maquinaria :") !!}
                <select class="selectpicker" id='maquinaria_id' name="maquinaria_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($maquinarias as $maquinaria)
                    @if ( $maquinaria->id == $manttoequipo->maquinaria_id)
                    <option value="{{$maquinaria->id}}" selected>{{ $maquinaria->descripcion}}</option>
                    @else
                    <option value="{{$maquinaria->id}}">{{ $maquinaria->descripcion}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                {!! Form::label("proveedor_id","Encargado de Mantenimiento:") !!}
                <select class="selectpicker" id='proveedor_id' name="proveedor_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($proveedores as $proveedor)
                    @if ( $proveedor->id == $manttoequipo->proveedor_id)
                    <option value="{{$proveedor->id}}" selected>{{ $proveedor->nombre}}</option>
                    @else
                    <option value="{{$proveedor->id}}">{{ $proveedor->nombre}}</option>
                    @endif
                    @endforeach
                </select> 
            </div>
            <div class="col-sm-4">
                {!! Form::label("fecha_servicio","Fecha Servicio:") !!}
                {!! Form::date( "fecha_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Servicio:' ]) !!}
            </div>
        </div>
        <br>
 
        <br>

        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("labadas_servicio","Cantidad de labadas Realizadas:") !!}
                {!! Form::number( "labadas_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad de Labadas Realizadas' ]) !!}
            </div>
            <div class="col-sm-4 ">
                {!! Form::label("labadas_proximo_servicio","Cantidad de labadas Para Proximo Servicio:") !!}
                {!! Form::text( "labadas_proximo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad de labadas Para Proximo Servicio' ]) !!}
            </div>
                 
            <div class="col-sm-4">
                {!! Form::label("fecha_proximo_servicio","Fecha Proximo Servicio:") !!}
                {!! Form::date( "fecha_proximo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Proximo Servicio' ]) !!}
            </div>
        
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("descripcion","Descripcion:") !!}
                {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion' ]) !!}
            </div>    
        </div>  
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/mantto_equipo') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateManttoEquipo']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/manttoequipo/edit.js') !!}
@endsection