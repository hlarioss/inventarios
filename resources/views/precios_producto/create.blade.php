@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'PrecioProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'PrecioProductoForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Precios </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("fecha","Fecha:") !!}
					{!! Form::text( "fecha" ,$fecha->format('d/m/y h:i:s') , ['class' => 'form-control', 'readonly']) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("producto_id","Producto:") !!}
					<select class="selectpicker" id='producto_id' name="producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($productos as $prodcuto)
						<option value="{{$prodcuto->id}}">{{ $prodcuto->codigo_barra}} - {{$prodcuto->nombre}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-4">
					{!! Form::label("precio_venta","Precio Venta:") !!}
					{!! Form::number( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio venta']) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/precios_producto') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonPrecioProducto']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/precios_producto/create.js') !!}
@endsection