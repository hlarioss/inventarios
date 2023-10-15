@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ManttoEquipoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ManttoEquipoForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Registro de Mantenimiento de Equipos </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">            
				<div class="col-sm-4">
					{!! Form::label("maquinaria_id","Maquinaria :") !!}
						<select class="selectpicker" id='maquinaria_id' name="maquinaria_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione Maquinaria">
							@foreach ($maquinarias as $maquinaria)
							<option value="{{$maquinaria->id}}">{{$maquinaria->nombre_maquina}}</option>
							@endforeach
						</select>
				</div>
				<div class="col-sm-4">
					{!! Form::label("proveedor_id","Encargado de Mantenimiento:") !!}
						<select class="selectpicker" id='proveedor_id' name="proveedor_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
							@foreach ($proveedores as $proveedor)
							<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
							@endforeach
					</select>
				</div>
				<div class="col-sm-4">
					{!! Form::label("fecha_servicio","Fecha Servicio:") !!}
					{!! Form::date( "fecha_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Servicio:' ]) !!}
				</div>
			</div>
			<br>
		 
				<br>
		
				<div class="row">
					<div class="col-sm-4">
						{!! Form::label("labadas_servicio","Cantidad de lavadas/horas Realizadas:") !!}
						{!! Form::number( "labadas_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad de Lavadas/horas Realizadas' ]) !!}
					</div>
					<div class="col-sm-4 ">
						{!! Form::label("labadas_proximo_servicio","Cantidad de lavadas/horas Para Proximo Servicio:") !!}
						{!! Form::text( "labadas_proximo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad de lavadas/horas Para Proximo Servicio' ]) !!}
					</div>
						 
					<div class="col-sm-4">
						{!! Form::label("fecha_proximo_servicio","Fecha Proximo Servicio:") !!}
						{!! Form::date( "fecha_proximo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Proximo Servicio' ]) !!}
					</div>
				
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12">
						{!! Form::label("descripcion","Descripcion:") !!}
						{!! Form::textarea( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion','rows'=>5 ]) !!}
					</div>    
				</div>  
				<br>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/mantto_equipo') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonManttoEquipo']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/manttoequipo/create.js') !!}
@endsection