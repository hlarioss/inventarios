@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($marca, ['method' => 'PATCH', 'action' => ['MarcasController@update', $marca->id], 'id' => 'MarcaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Marca </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("nombre","Marca:") !!}
                {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Marca' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("tipo_marca_id","Tipo de Marca:") !!}
                <select class="selectpicker" id='tipo_marca_id' name="tipo_marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_marcas as $tipo_marca)
                    @if ( $tipo_marca->id == $marca->tipo_marca_id)
                    <option value="{{$tipo_marca->id}}" selected>{{ $tipo_marca->nombre}}</option>
                    @else
                    <option value="{{$tipo_marca->id}}">{{ $tipo_marca->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/marcas') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateMarca']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/marcas/edit.js') !!}
@endsection