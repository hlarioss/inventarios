@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($precio_producto, ['method' => 'PATCH', 'action' => ['PreciosProductoController@update', $precio_producto->id], 'id' => 'PrecioProductoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición Precios </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("producto_id","Producto:") !!}
                <select class="selectpicker" id='producto_id' name="producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($productos as $producto)
                    @if ( $producto->id == $precio_producto->producto_id)
                    <option value="{{$producto->id}}" selected>{{ $prodcuto->codigo_barra}} - {{ $producto->nombre}}</option>
                    @else
                    <option value="{{$producto->id}}">{{ $prodcuto->codigo_barra}} - {{ $producto->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
				{!! Form::label("precio_venta","Precio Venta:") !!}
				{!! Form::text( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio venta']) !!}
			</div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/precios_producto') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdatePrecioProducto']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/precios_producto/edit.js') !!}
@endsection