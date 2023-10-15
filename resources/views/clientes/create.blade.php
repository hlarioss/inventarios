@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'ClienteForm') ) !!}
		@include('clientes.formularioCliente')

		<div class="text-right m-t-15">
			<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/clientes') }}">Regresar</a>
			{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonCliente']) !!}
		</div>
		<input type="hidden" name="_token" id="tokenCliente" value="{{ csrf_token() }}">
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/clientes/create.js') !!}
@endsection