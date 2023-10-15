@extends('layouts.app')
@section('content')
@include('clientes.createModal')
@include('venta.facturaModal')
<div id="content">
	<div class="container-custom">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Creación de Ventas</h3>
				<line>
			</div>
		</div>
		
		<br>
		<div class="row">
			<div class="col-sm-3">
				{!! Form::label("cliente","Cliente:") !!}
				<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione Cliente">
					@foreach ($clientes as $cliente)
					<option value="{{$cliente->id}}">{{$cliente->nombres}}</option>
					@endforeach
				</select>
				<br>
				<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" id="modalCliente" type="button">
				<i class="fa fa-plus"></i>Nuevo Cliente</button>
			</div>
			<div class="col-sm-3">
				{!! Form::label("nit_c","NIT:") !!}
				{!! Form::text( "nit_c" , null, ['class' => 'form-control' , 'placeholder' => 'NIT']) !!}
			</div>
			<div class="col-sm-3">
				{!! Form::label("direccion","Direccion:") !!}
				{!! Form::text( "direccion" , null , ['class' => 'form-control', 'placeholder' => 'direccion' ]) !!}
			</div>
			<div class="col-sm-2">
				{!! Form::label("tipo_pago","Tipo Pago:") !!}
				
				<input type="number" class="hide" id="tipo_pago_id" name="tipo_pago_id" value="1" >
	
				<select class="form-control" id='tipo_pago' name="tipo_pago" value="{{ old('role')}}">
					@foreach ($tipo_pagos as $tipo_pago)
					<option value="{{$tipo_pago->id}}">{{ $tipo_pago->tipo_pago}}</option>;
					@endforeach
				</select>
				<span id="api-type-error" class="help-block hidden">
					<strong></strong>
				</span>
			</div>
			
		</div>
		<div class="row">
			<div class="col-sm-4">
				{!! Form::hidden( "fecha_venta" , $today, ['class' => 'form-control', 'disabled']) !!}
			</div>
			
		</div>
		<hr>
		<h3> Agregar Producto</h3>
		<br>
		<div class="row">
			<div class="col-sm-6">
			{!! Form::label("codigo_barra","produccto:") !!}
				<select class="selectpicker" id='codigo_barra' name="codigo_barra" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione produccto">
					@foreach ($productos as $cliente)
					<option value="{{$cliente->codigo_barra}}">{{$cliente->codigo_barra}}- {{$cliente->nombre}}</option>
					@endforeach
				</select>
			</div>
			{{--
			<div class="col-sm-6">
				{!! Form::label("codigo","Código de Barras:") !!}
				{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Código de Barras' ]) !!}
			</div>
		--}}
			<div class="col-sm-3">
				{!! Form::label("cantidad","Cantidad:") !!}
				{!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad']) !!}
			</div>
			<div class="col-sm-3">
				{!! Form::label("subtotal","Sub-Total:") !!}
				{!! Form::text( "subtotal" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => 'Sub-Total' ]) !!}
			</div>
		</div>
		<br>
		<div class="row">
		
			<div class="col-sm-6">
				{!! Form::label("Descripción","Descripción:") !!}
				{!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'disabled',  'placeholder' => 'Descripción del Producto' ]) !!}
				<span id="api-type-error" class="help-block hidden">
					<strong></strong>
				</span>
			</div>
			
			<div class="col-sm-3">
				{!! Form::label("venta","Precio de Venta:") !!}
				{!! Form::text( "precio_venta" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => 'Precio de Venta' ]) !!}
				{!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!}
				{!! Form::hidden("precio_compra" , null , ['class' => 'form-control' , 'disabled']) !!}
				{!! Form::hidden("precio_id" , null , ['class' => 'form-control' , 'disabled']) !!}
				{!! Form::hidden("movimiento_id" , null , ['class' => 'form-control' , 'disabled']) !!}
				{!! Form::hidden("cantidadu" , null , ['class' => 'form-control' , 'disabled']) !!}
				{!! Form::hidden("existencias" , null , ['class' => 'form-control' , 'disabled']) !!}
				{!! Form::hidden("venta_maestro" , null , ['class' => 'form-control' , 'disabled']) !!}
			</div>
			<br>
			<div class="col-sm-3">
				{!! Form::submit('Agregar Nuevo Producto' , ['class' => 'btn btn-success' ,
				'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
			</div>
			
		</div>
		<div id='total_existencia' style="font-size:16px; font-weight:bold; color:green"> </div>
		<br>
		
		<hr>
		{{---
		<h3> Agregar Servicio</h3>
		<br>
		<div class="row">
			<div class="col-sm-3">
				{!! Form::label("servicio","Servicio:") !!}
				<select class="selectpicker" id='servicio_id' name="servicio_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
					@foreach ($servicios as $servicio)
					<option value="{{$servicio->id}}"><p id="servicio"	>{{$servicio->nombre}}</p> </option>
					@endforeach
				</select>
			</div>
			<div class="col-sm-2">
				{!! Form::label("cantidad","Cantidad:") !!}
				{!! Form::number( "cantidad_s" , 1, ['class' => 'form-control' , 'placeholder' => 'Cantidad']) !!}
			</div>
			<div class="col-sm-2">
				{!! Form::label("precio","Precio:") !!}
				<div class="input-group">
					{!! Form::hidden("venta_maestro" , null , ['class' => 'form-control' , 'disabled']) !!}
					<span class="input-group-addon">Q</span>
					{!! Form::number( "precio" , null , ['class' => 'form-control', 'placeholder' => '0.00' ]) !!}
				</div>
			</div>
			<div class="col-sm-2">
				{!! Form::label("subtotal_s","Sub-Total:") !!}
				{!! Form::text( "subtotal_s" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => 'Sub-Total' ]) !!}
			</div>
			<br>
			<div class="col-sm-3">
				{!! Form::submit('Agregar servicio', ['class' => 'btn btn-danger', 'id'=>'addDetalleServicio']) !!}	
			</div>
		</div>
		
		<hr>
		<h3> Agregar Mano de Obra</h3>
		<br>
		<div class="row">
			<div class="col-sm-6">
				{!! Form::label("descripcion_m","Descripcion :") !!}
				{!! Form::text( "descripcion_m" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion' ]) !!}
			</div>
			<div class="col-sm-3">
				{!! Form::label("precio_m","Precio:") !!}
				<div class="input-group">
					<span class="input-group-addon">Q</span>
					{!! Form::number( "precio_m" , null , ['class' => 'form-control', 'placeholder' => '0.00' ]) !!}
				</div>
			</div>
			<br>
			<div class="col-sm-3">
				{!! Form::submit('Agregar Mano de Obra' , ['class' => 'btn btn-danger' ,
				'id' => 'addManoObra', 'data-loading-text' => 'Processing...' ]) !!}
			</div>	
		</div>
		
		<hr>
--}}
		<br>

		<div id="detalle-grid"></div>

		<div class="row">
			<br>
			<div class="col-sm-3" id="total">
				{!! Form::label("Total","Total:") !!}
				{!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
			</div>
			<div class="col-sm-3" id="total">
				{!! Form::label("Efectivo","Efectivo:") !!}
				{!! Form::text( "efectivo" , null, ['class' => 'form-control', 'id' => 'efectivo']) !!}
			</div>
			<div class="col-sm-3" id="total">
				{!! Form::label("Cambio","Cambio:") !!}
				{!! Form::text( "cambio", null, ['class' => 'form-control', 'id' => 'cambio', 'disabled']) !!}
			</div>
			<br>
			<div class="col-sm-3">
					
				{!! Form::button('Guardar Venta' , ['class' => 'btn btn-success' ,
				'id' => 'ButtonDetalle', 'data-loading-text' => 'Processing...' ]) !!}
			
			</div>
		</div>
		<br>
		
			
	</div>
</div>
@endsection

	

@section('scripts')
{!! HTML::script('/js/clientes/create.js') !!}
{!! HTML::script('/js/venta/create.js') !!}
{!! HTML::script('/js/venta/edit.js') !!}

@endsection