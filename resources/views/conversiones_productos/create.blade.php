@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Conversiones de Producto </h3>
				<line>
				</div> 
		</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					<h4 class="tittle-custom">Sale</h4>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-2">
					{!! Form::hidden("precio_sale" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::label("codigo_barra_sale","Codigo de Barra:") !!}
					{!! Form::hidden("producto_id_sale" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::hidden("subtotal_sale" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::text( "codigo_barra_sale" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Barra' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("nombre_sale","Descripcion del Producto:") !!}
					{!! Form::text( "nombre_sale" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Descripcion del producto' ]) !!}
				</div>

				<div class="col-sm-2">
					{!! Form::label("unidad_de_medida_sale","Unidad de medida:") !!}
					{!! Form::text( "unidad_de_medida_sale" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Unidad de medida' ]) !!}
					{!! Form::hidden("cantidad_medida_sale" , null , ['class' => 'form-control' , 'disabled']) !!}
				</div>

				<div class="col-sm-2">
					{!! Form::label("cantidad_sale","Cantidad:") !!}
					{!! Form::text( "cantidad_sale" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h4 class="tittle-custom">Ingresa</h4>
				</div>
			</div>
			
			<br>
			<div class="row">
				<div class="col-sm-2">
					{!! Form::label("codigo_barra","Codigo de Barra:") !!}
					{!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::hidden("subtotal" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Barra' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("nombre","Descripcion del Producto:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Descripcion del producto' ]) !!}
				</div>

				<div class="col-sm-2">
					{!! Form::label("unidad_de_medida","Unidad de medida:") !!}
					{!! Form::text( "unidad_de_medida" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Unidad de medida' ]) !!}
					{!! Form::hidden("cantidad_medida" , null , ['class' => 'form-control' , 'disabled']) !!}
				</div>

				<div class="col-sm-2">
					{!! Form::label("cantidad_ingreso","Cantidad:") !!}
					{!! Form::text( "cantidad_ingreso" , null , ['class' => 'form-control' ,'disabled', 'placeholder' => 'Cantidad' ]) !!}
				</div>

				<div class="col-sm-2">
					{!! Form::label("precio_compra","Precio Compra:") !!}
					{!! Form::text( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Compra' ]) !!}
					{!! Form::hidden("cus" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::hidden("cui" , null , ['class' => 'form-control' , 'disabled']) !!}
				</div>

			
			</div>
			<br>				
	
	
			<br>

			<div class="text-right m-t-15">
				{!! Form::button('Agregar' , ['class' => 'btn btn-success' ,'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
			</div>				
			<hr>	

			<div class="row">
				<div class="col-sm-12" id="detalle-grid"> </div>	
			</div>

			<br>
			<div class="col-sm-4" id="total">
				<h3>{!! Form::hidden("total","Total:") !!}</h3>
				{!! Form::hidden( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
			</div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/conversiones_productos') }}">Regresar</a>
				{!! Form::submit('Guardar' , ['class' => 'btn btn-success btn-submit-ingresoproducto', 'id' => 'ButtonGuardar', 'data-loading-text' => 'Processing...' ]) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	</div>
</div>

@endsection

@section('scripts')

{!! HTML::script('/js/conversiones_productos/create.js') !!}

@endsection