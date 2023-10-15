@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ProductoForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Productos </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("codigo_barra","Codigo de barra:") !!}
					{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo de barra']) !!}
				</div>
				<div class="col-sm-8">
					{!! Form::label("nombre","Nombre:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre']) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("marca_id","Marca :") !!}
						<select class="selectpicker" id='marca_id' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione La Marca">
							@foreach ($marcas as $marca)
							@if ( $marca->tipo_marca_id == 1 or $marca->tipo_marca_id == 3 )
							<option value="{{$marca->id}}">{{$marca->nombre}}</option>
							@endif
							@endforeach
					</select>
				</div>
				<div class="col-sm-4">
					{!! Form::label("medida_id","Unidad de Medida:") !!}
						<select class="selectpicker" id='medida_id' name="medida_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione La Medida">
							@foreach ($medidas as $medida)
							<option value="{{$medida->id}}">{{$medida->descripcion}}</option>
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
					{!! Form::label("localidad_id","Ubicación:") !!}
						<select class="selectpicker" id='localidad_id' name="localidad_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione La Ubicación">
							@foreach ($localidades as $medida)
							<option value="{{$medida->id}}">{{$medida->nombre}}</option>
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
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonProducto']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/productos/create.js') !!}
@endsection