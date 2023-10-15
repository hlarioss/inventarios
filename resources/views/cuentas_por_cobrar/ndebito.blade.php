@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array('class'=> 'form', 'id' => 'NotaDebitoForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Ajuste (Nota de Debito) </h3>
				<line>
			</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("cliente_id","Cliente:") !!}
						<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
							@foreach ($clientes as $cliente)
							<option value="{{$cliente->id}}">{{$cliente->nombres}} {{$cliente->apellidos}}</option>
							@endforeach
						</select>
				</div>
				<div class="col-sm-3">
					{!! Form::label("no_factura","No. Documento:") !!}
					{!! Form::text( "no_factura" , null , ['class' => 'form-control' , 'placeholder' => 'No. Documento:' ]) !!}	
				</div>
				<div class="col-sm-3">
					{!! Form::label("fecha_documento","Fecha documento:") !!}
					{!! Form::date( "fecha_documento" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha documento' ]) !!}	
				</div>
                <div class="col-sm-3">
					{!! Form::label("total","Total:") !!}
					{!! Form::text( "total" , null , ['class' => 'form-control' , 'placeholder' => 'Total' ]) !!}	
				</div>
			</div>		
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/cuentas_por_cobrar') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonNotaDebito']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/cuentas_por_cobrar/create.js') !!}
@endsection