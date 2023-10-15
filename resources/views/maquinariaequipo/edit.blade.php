@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($maquinariaequipo, ['method' => 'PATCH', 'action' => ['MaquinariasEquipoController@update', $maquinariaequipo->id], 'id' => 'MaquinariaEquipoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h2 class="tittle-custom"> Edición de Maquinarias/Equipo </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("codigo_maquina","Codigo:") !!}
                {!! Form::text( "codigo_maquina" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre del equipo' ]) !!}
            </div>
            
            <div class="col-sm-4">
                {!! Form::label("nombre_maquina","Nombre:") !!}
                {!! Form::text( "nombre_maquina" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre del equipo' ]) !!}
            </div>
            
            <div class="col-sm-4">
                {!! Form::label("marca","Marca :") !!}
                <select class="selectpicker" id='marca' name="marca" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($marcas as $marca)
                    @if ( $marca->id == $maquinariaequipo->marca)
                    <option value="{{$marca->id}}" selected>{{ $marca->nombre}}</option>
                    @else
                    @if ( $marca->tipo_marca_id == 1 or $marca->tipo_marca_id == 4 )
						<option value="{{$marca->id}}">{{$marca->nombre}}</option>
						@endif
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label("labadas_limite","Horas  Limite:") !!}
                {!! Form::text( "labadas_limite" , null , ['class' => 'form-control' , 'placeholder' => 'Horas de Vida de la Maquinaria' ]) !!}
            </div>
            <div class="col-sm-6">
                {!! Form::label("fecha_adquisicion","Fecha de Adquisicion:") !!}
                {!! Form::date( "fecha_adquisicion" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Adquisicion' ]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("descripcion","Descripción:") !!}
                {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripción' ]) !!}
            </div>
        </div>
        <br>
    </div>
    <br>
    <div class="text-right m-t-15">
        <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/maquinarias_equipo') }}">Regresar</a>
        {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateMaquinariaEquipo']) !!}
    </div>
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</br>
{!! Form::close() !!}
</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/maquinariaequipo/edit.js') !!}
@endsection