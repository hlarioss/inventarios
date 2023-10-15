@extends('layouts.app')
@section('content')
<div id="content">
	<div class="content">
	<div class="container-custom">
		{{--{!! Form::open( array( 'id' => 'ServicioForm') ) !!}--}}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Servicio </h3>
				<line>
			</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-2">
					{!! Form::label("tipo_servicio_id","Tipo de Servicio:") !!}
					<select class="selectpicker" id='tipo_servicio_id' name="tipo_servicio_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						<option disabled selected>Selecciona</option>
						@foreach ($tipos_servicio as $tipo_servicio)
						<option value="{{$tipo_servicio->id}}">{{$tipo_servicio->nombre}}</option>							
						@endforeach
					</select>
				</div>
				<div class="col-sm-2">
					{!! Form::label("codigo","Codigo Interno:") !!}
					{!! Form::text( "codigo" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo de servicio' ]) !!}
				</div>
				<div class="col-sm-8">
					{!! Form::label("nombre","Nombre Servicio:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre servicio' ]) !!}
				</div>
				
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("precio_costo","Precio Costo sin Mano de Obra:") !!}
					{!! Form::number( "precio_costo" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Costo sin Mano de Obra', 'disabled' => true ]) !!}
	
				</div>
				<div class="col-sm-4">
					{!! Form::label("precio","Precio Venta sin Mano de Obra:") !!}
					{!! Form::number( "precio" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Venta sin Mano de Obra' ]) !!}
	
				</div>

			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					<h4 class="tittle-custom">Productos</h4>
					<line>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("cantidad","Cantidad:") !!}
					{!! Form::number( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
					{!! Form::hidden("unidad_cantidad" , null , ['class' => 'form-control' , 'disabled']) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("unidad_de_medida_id","Unidad de medida:") !!}
					<select class="selectpicker" id='unidad_de_medida_id' name="unidad_de_medida_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						<option value="" selected>Unidad de medida</option>
						@foreach ($unidades_de_medida as $unidad_de_medida)
						<option value="{{$unidad_de_medida->id}}">{{$unidad_de_medida->descripcion}}</option>							
						@endforeach
					</select>
				</div>
				<div class="col-sm-3">
					{!! Form::label("producto_id","Producto:") !!}
					<select class="selectpicker" id='producto_id' name="producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						<option value="" selected>Selecciona Producto</option>
						@foreach ($productos as $producto)
						<option value="{{$producto->id}}">{{$producto->nombre}}</option>							
						@endforeach
					</select>
					{!! Form::hidden("subtotal" , null , ['class' => 'form-control' , 'disabled']) !!}
				</div>
				<div class="col-sm-2">
					{!! Form::label("costo_producto","Costo:") !!}
					{!! Form::number( "costo_producto" , null , ['class' => 'form-control' , 'placeholder' => 'Costo' ]) !!}
				</div>
				<div class="col-sm-1">
					{!! Form::label("addProducto"," ") !!}
					{!! Form::button('Agregar' , ['class' => 'btn btn-success' ,'id' => 'addProducto', 'data-loading-text' => 'Processing...' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					<h4 class="tittle-custom">Maquinaria y/o Equipo</h4>
					<line>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("cantidad_maquina","Cantidad:") !!}
					{!! Form::number( "cantidad_maquina" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("unidad_de_medida_id","Unidad de medida:") !!}
					<select class="selectpicker" id='unidad_de_medida_id2' name="unidad_de_medida_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						<option value="" selected>Unidad de medida</option>
						@foreach ($unidades_de_medida as $unidad_de_medida)
						<option value="{{$unidad_de_medida->id}}">{{$unidad_de_medida->descripcion}}</option>							
						@endforeach
					</select>
				</div>
				<div class="col-sm-3">
					{!! Form::label("maquinaria_equipo_id","Maquinaria y/o Equipo:") !!}
					<select class="selectpicker" id='maquinaria_equipo_id' name="maquinaria_equipo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						<option value="" selected>Selecciona</option>
						@foreach ($maquinarias as $maquinaria)
						<option value="{{$maquinaria->id}}">{{$maquinaria->nombre_maquina}}</option>							
						@endforeach
					</select>
					{!! Form::hidden("subtotalmaquina" , null , ['class' => 'form-control' , 'disabled']) !!}
				</div>
				<div class="col-sm-2">
					{!! Form::label("costo_maquinaria","Costo:") !!}
					{!! Form::number( "costo_maquinaria" , null , ['class' => 'form-control' , 'placeholder' => 'Costo' ]) !!}
				</div>
				<div class="col-sm-1">
					{!! Form::label("addMaquinaria"," ") !!}
					{!! Form::button('Agregar' , ['class' => 'btn btn-success' ,'id' => 'addMaquinaria', 'data-loading-text' => 'Processing...' ]) !!}
				</div>
			</div>
			<br>
			<div id="servicio-grid"></div>
			<br>

			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/servicios') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonServicio']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	{{--{!! Form::close() !!}--}}
	</div>
</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/servicios/create.js') !!}
@endsection