@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($producto, ['method' => 'PATCH', 'action' => ['ProductosController@update', $producto->id], 'id' => 'ProductoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Productos </h3>
            </div>
        </div>
        <br>
        <div class="row">
			<div class="col-sm-4 {{$errors->has('codigo_barra')? 'has-error' : ''}} ">
				{!! Form::label("codigo_barra","Codigo de barra:") !!}
                {!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo de barra']) !!}
                {!!$errors->first('codigo_barra', '<label class="error">:message</label>')!!}
            </div>
			<div class="col-sm-8">{!! Form::label("nombre","Nombre:") !!}
				{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre']) !!}
			</div>
		</div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                    {!! Form::label("marca_id","Marca :") !!}
                    <select class="selectpicker" id='marca_id' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                        @foreach ($marcas as $marca)
                        @if ( $marca->id == $producto->marca_id)
                        <option value="{{$marca->id}}" selected>{{ $marca->nombre}}</option>
                        @else
                        @if ( $marca->tipo_marca_id == 1 or $marca->tipo_marca_id == 3 )
                            <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                            @endif
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                        {!! Form::label("medida_id","Unidad de Medida :") !!}
                        <select class="selectpicker" id='medida_id' name="medida_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                            @foreach ($medidas as $medida)
                            @if ( $medida->id == $producto->medida_id)
                            <option value="{{$medida->id}}" selected>{{ $medida->descripcion}}</option>
                            @else
                             <option value="{{$medida->id}}">{{$medida->descripcion}}</option>                           
                            @endif
                            @endforeach
                        </select>
                </div>
            <div class="col-sm-4">
                {!! Form::label("minimo","Stock Minimo:") !!}
                {!! Form::number( "minimo" , null , ['class' => 'form-control' , 'placeholder' => 'Stock minimo']) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("localidad_id","Ubicación :") !!}
                <select class="selectpicker" id='localidad_id' name="localidad_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($localidades as $marca)
                    @if ( $marca->id == $producto->localidad_id)
                    <option value="{{$marca->id}}" selected>{{ $marca->nombre}}</option>
                    @else
                    <option value="{{$marca->id}}">{{$marca->nombre}}</option> 
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-9">
                {!! Form::label("descripcion","Descripcion:") !!}
                {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Ingrese la descripcion del producto']) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/productos') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateProducto']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/productos/edit.js') !!}
@endsection