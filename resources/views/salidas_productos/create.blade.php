@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Salida </h3>
				<line>
				</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::hidden( "fecha_salida" ,\Carbon\Carbon::now()->format('d-m-y') , ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id' => 'fecha_salida' ]) !!}
				</div>
			</div>	
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("codigo_barra","Codigo de Barra:") !!}
					{!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::hidden("subtotal" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Barra' ]) !!}
				</div>

				<div class="col-sm-8">
					{!! Form::label("nombre","Descripcion del Producto:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Descripcion del producto' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("cantidad_salida","Cantidad:") !!}
					{!! Form::text( "cantidad_salida" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("precio_compra","Precio de compra:") !!}
					{!! Form::text( "precio_compra" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Precio de compra' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("tipo_salida_id","Tipo de salida:") !!}
					<select class="selectpicker" id='tipo_salida_id' name="tipo_salida_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($tipos_salida as $tipo_salida)
						<option value="{{$tipo_salida->id}}">{{$tipo_salida->tipo_salida}}</option>
						@endforeach
					</select>
				</div>

				
			</div>

			<br>
	
				<div class="text-right m-t-15">
					{!! Form::button('Agregar Producto' , ['class' => 'btn btn-success' ,'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
				</div>				
			<br>
				<hr>	

			<div id="detalle-grid">

			</div>
			<br>
			<div class="col-sm-4" id="total">
				<h3>{!! Form::label("total","Total:") !!}</h3>
				{!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
			</div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/salidas_productos') }}">Regresar</a>
				{!! Form::submit('Guardar' , ['class' => 'btn btn-success btn-submit-salidaproducto', 'id' => 'ButtonGuardar', 'data-loading-text' => 'Processing...' ]) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	</div>
</div>

@endsection

@section('scripts')

{!! HTML::script('/js/salidas_productos/create.js') !!}

@endsection