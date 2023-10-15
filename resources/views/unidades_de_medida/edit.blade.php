@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($unidad_de_medida, ['method' => 'PATCH', 'action' => ['UnidadesDeMedidaController@update', $unidad_de_medida->id], 'id' => 'UnidadDeMedidaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Unidades de Medida </h3>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-sm-4">
                    {!! Form::label("descripcion","Descripcion:") !!}
                    {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion' ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label("cantidad","Cantidad:") !!}
                    {!! Form::number( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label("unidad_de_medida_id","Unidad de medida:") !!}
                    <select class="selectpicker" id='unidad_de_medida_id' name="unidad_de_medida_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                        @foreach ($unidades_de_medida as $unidad_de_medida)
                        @if ( $unidad_de_medida->id == $unidad_de_medida->unidad_de_medida_id)
                        <option value="{{$unidad_de_medida->id}}" selected>{{ $unidad_de_medida->descripcion}}</option>
                        @else
                        <option value="{{$unidad_de_medida->id}}">{{ $unidad_de_medida->descripcion}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/unidades_de_medida') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateUnidadDeMedida']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/unidades_de_medida/edit.js') !!}
@endsection