@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($linea, ['method' => 'PATCH', 'action' => ['LineasController@update', $linea->id], 'id' => 'LineaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Lineas </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("linea","Linea:") !!}
                {!! Form::text( "linea" , null , ['class' => 'form-control' , 'placeholder' => 'Linea' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("marca_id","Marca:") !!}
                <select class="selectpicker" id='marca_id' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($marcas as $marca)
                    @if ( $marca->id == $linea->marca_id)
                    <option value="{{$marca->id}}" selected>{{ $marca->nombre}}</option>
                    @else
                    @if($marca->tipo_marca_id== 1 or $marca->tipo_marca_id== 2 )
                    <option value="{{$marca->id}}">{{ $marca->nombre}}</option>
                    @endif
                    @endif
                    @endforeach
                </select>
            </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/lineas') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateLinea']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/lineas/edit.js') !!}
@endsection