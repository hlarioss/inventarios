@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		@include('clientes.createModal')
		@include('vehiculos.createModalVehiculo')
		{!! Form::model($orden, ['method' => 'PATCH', 'action' => ['OrdenesDeTrabajoController@update', $orden->id], 'id' => 'CreateUpdateForm']) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Orden de Trabajo </h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-0">
					{{--<input type="datetime-local" class="form-control" name="fecha_hora" value="{{\Carbon\Carbon::now()}}"> --}}
					{!! Form::datetime( "fecha_hora" , \Carbon\Carbon::now()->format('d-m-y h:i:s A') , ['class' => 'form-control hidden']) !!}	
				</div>
				<div class="col-sm-6">
					{!! Form::label("resp_recepcion","Responsable de la recepcion:") !!}
					{!! Form::text( "resp_recepcion" , Auth::user()->name , ['class' => 'form-control','disabled' , 'placeholder' => 'Responsable de la recepcion' ]) !!}
				</div>
				<div class="col-sm-6">
					{!! Form::label("fecha_prometida","Fecha de entrega prometida:") !!}
					{!! Form::date( "fecha_prometida" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha y Hora' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("cliente_id","Cliente:") !!}
					<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($clientes as $cliente)
						@if ( $cliente->id == $orden->cliente_id)
						<option value="{{$cliente->id}}" selected>{{$cliente->nombres.' '.$cliente->apellidos}}</option>
						@else
						<option value="{{$cliente->id}}">{{$cliente->nombres.' '.$cliente->apellidos}}</option>
						@endif
						@endforeach
					</select>
					<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal" id="modalCliente" type="button">
							<i class="fa fa-plus"></i>Nuevo Cliente</button>
				</div>

				<div class="col-sm-6">
					{!! Form::label("vehiculo_id","Vehiculo:") !!}
					<select class="selectpicker" id='vehiculo_id' name="vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($vehiculos as $vehiculo)
						@if ( $vehiculo->id == $orden->vehiculo_id)
						<option value="{{$vehiculo->id}}" selected>{{$vehiculo->placa}}</option>
						@else
						<option value="{{$vehiculo->id}}">{{$vehiculo->placa}}</option>
						@endif
						@endforeach
					</select>
					<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#ModalVehiculo" id="modalvehiculo" type="button">
							<i class="fa fa-plus"></i>Nuevo Vehiculo</button>
				</div>
			</div>
			<br>
			<div class="row">
		
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ordenes_de_trabajo') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Siguiente', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonOrdenDeTrabajo']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection


@stack('scripts')

@section('scripts')
{!! HTML::script('/js/ordenes_de_trabajo/editcreate.js') !!}
{!! HTML::script('/js/ordenes_de_trabajo/create.js') !!}
{!! HTML::script('/js/clientes/create.js') !!}
{!! HTML::script('/js/vehiculos/create.js') !!}
@endsection