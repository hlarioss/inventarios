@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
			@include('proveedores.createModalProveedor')
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Compras </h3>
				<line>
				</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("fecha_ingreso","Fecha Compra:") !!}
					{!! Form::date( "fecha_ingreso" , Carbon\Carbon::now() , ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id' => 'fecha_ingreso' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("tipo_pago_id","Tipo de pago:") !!}
					<select class="selectpicker" id='tipo_pago_id' name="tipo_pago_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($tipos_pago as $tipo_pago)

						@if ( $tipo_pago->id == 1)
						<option value="{{$tipo_pago->id}}" selected>{{ $tipo_pago->tipo_pago}}</option>
						@else
						<option value="{{$tipo_pago->id}}">{{$tipo_pago->tipo_pago}}</option>
						@endif

						@endforeach
					</select>
				</div>
			</div>	
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("proveedor_id","Proveedor:") !!}
					<select class="form-control" id='proveedor_id' name="proveedor_id" value="" data-live-search-placeholder="Búsqueda" title="Seleccione">
					</select>
					<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalProveedor" id="modalproveedor" type="button">
						<i class="fa fa-plus"></i>Nuevo Proveedor</button>
				</div>

				<div class="col-sm-3">
					{!! Form::label("fecha_factura","Fecha factura:") !!}
					{!! Form::date( "fecha_factura" , Carbon\Carbon::now() , ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id' => 'fecha_factura' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("serie_factura","No. Serie:") !!}
					{!! Form::text( "serie_factura" , null , ['class' => 'form-control' , 'placeholder' => 'No. Serie' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("num_factura","No. Factura:") !!}
					{!! Form::text( "num_factura" , null , ['class' => 'form-control' , 'placeholder' => 'No. Factura' ]) !!}
				</div>	
			</div>
			<hr>

			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("codigo_barra","Codigo de Barra:") !!}
					{!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::hidden("subtotal" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Barra' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("nombre","Descripcion del Producto:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Descripcion del producto', 'id' => 'nombreProducto']) !!}
				</div>

				<div class="col-sm-2">
					{!! Form::label("cantidad_ingreso","Cantidad:") !!}
					{!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
				</div>
				<div class="col-sm-2">
					{!! Form::label("unidades_ingreso","Unidades del Producto:") !!}
					{!! Form::text( "unidades" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Unidades del producto', 'id' => 'nombreProducto']) !!}
				</div>
				<div class="col-sm-2">
					{!! Form::label("precio_compra","Precio Unitario de Compra:") !!}
					{!! Form::text( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Compra' ]) !!}
				</div>
	
			</div>
			<input type="hidden" name="aux" id="aux">
			<br>
	
				<div class="text-right m-t-15">
					{!! Form::button('Agregar Nuevo Producto' , ['class' => 'btn btn-success' ,'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
				</div>				
			<br>
			<hr>
			{{--
			<div class="row">
					<div class="col-sm-3">
						{!! Form::label("codigo_maquina","Codigo de Maquina:") !!}
						{!! Form::hidden("maquinaria_equipo_id" , null , ['class' => 'form-control' , 'disabled']) !!}
						{!! Form::hidden("subtotalmaquina" , null , ['class' => 'form-control' , 'disabled']) !!}
						{!! Form::text( "codigo_maquina" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Maquina' ]) !!}
					</div>
	
					<div class="col-sm-3">
						{!! Form::label("nombre_maquina","Descripcion:") !!}
						{!! Form::text( "nombre_maquina" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Descripcion de maquinaria' ]) !!}
					</div>
	
					<div class="col-sm-2">
						{!! Form::label("cantidad_ingreso","Cantidad:") !!}
						{!! Form::text( "cantidad_maquina" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
					</div>
	
					<div class="col-sm-2">
						{!! Form::label("precio_compra_maquina","Precio Compra:") !!}
						{!! Form::text( "precio_compra_maquina" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Compra' ]) !!}
					</div>
	
				</div>
			
				<br>
					<div class="text-right m-t-15">
						{!! Form::button('Agregar Nueva maquina' , ['class' => 'btn btn-success' ,'id' => 'addDetalleMaquina', 'data-loading-text' => 'Processing...' ]) !!}
					</div>
				<br>
				<hr>	
--}}
			<div id="compradetalle-grid">

			</div>
			<br>
			<div class="col-sm-4" id="total">
				<h3>{!! Form::label("total","Total:") !!}</h3>
				{!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
			</div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/compras') }}">Regresar</a>
				{!! Form::submit('Agregar Nueva Compra' , ['class' => 'btn btn-success btn-submit-ingresoproducto', 'id' => 'ButtonDetalle', 'data-loading-text' => 'Processing...' ]) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	</div>
</div>

@endsection



@section('scripts')
{!! HTML::script('/js/proveedores/create.js') !!}
{!! HTML::script('/js/compras/create.js') !!}
{!! HTML::script('/js/compras/grid.js') !!}

@endsection