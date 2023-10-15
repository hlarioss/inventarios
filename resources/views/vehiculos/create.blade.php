@extends('layouts.app')
@section('content')

<div id="content">
	<div class="container-custom">
		@include('marcas.createmarcaModal')
		@include('lineas.createlineaModal')
		{!! Form::open( array( 'id' => 'VehiculoForm') ) !!}
		
		@include('vehiculos.formularioVehiculo')

			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/vehiculos') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonVehiculo']) !!}
			</div>

			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection


@stack('scripts')
@section('scripts')
{!! HTML::script('/js/vehiculos/create.js') !!}
{!! HTML::script('/js/marcas/create.js') !!}
{!! HTML::script('/js/lineas/create.js') !!}
@endsection

