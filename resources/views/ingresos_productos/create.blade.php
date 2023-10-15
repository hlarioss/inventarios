@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Ingreso </h3>
				<line>
				</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::hidden( "fecha_ingreso" ,\Carbon\Carbon::now()->format('d-m-y') , ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id' => 'fecha_ingreso' ]) !!}
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
					{!! Form::label("cantidad","Cantidad:") !!}
					{!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
				</div>

				<div class="col-sm-4">
					{!! Form::label("precio_compra","Precio Compra:") !!}
					{!! Form::text( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Compra' ]) !!}
				</div>

				<div class="col-sm-4">
						{!! Form::label("precio_venta","Precio Venta:") !!}
						{!! Form::text( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio venta' ]) !!}
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
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ingresos_productos') }}">Regresar</a>
				{!! Form::submit('Guardar' , ['class' => 'btn btn-success btn-submit-ingresoproducto', 'id' => 'ButtonGuardar', 'data-loading-text' => 'Processing...' ]) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	</div>
</div>

@endsection

@section('scripts')

{!! HTML::script('/js/ingresos_productos/create.js') !!}

@endsection