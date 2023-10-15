@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'FacturaForm')) !!} -->
		{!! Form::open( array( 'id' => 'FacturaForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Factura </h3>
				<line>
				</div>
			</div>
			<br>
		
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("serie_id","Serie:") !!}
					<select class="selectpicker" id='serie_id' name="serie_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($series as $serie)
							@if($serie->documento_id == 1 && $serie->estado_id == 2)
								<option value="{{$serie->id}}">{{ $serie->serie}}</option>
							@endif
						@endforeach
					</select>
				</div>
				<div class="col-sm-4 form-group ">
					{!! Form::label("numero","Numero:") !!}
					{!! Form::text( "numero" , null , ['class' => 'form-control' , 'placeholder' => 'Numero:', 'id'=>'numero_f' ]) !!}
					
				</div>		
				<div class="col-sm-4">
					{!! Form::label("tipo_pago_id","Tipo de Pago:") !!}
					<select class="selectpicker" id='tipo_pago_id' name="tipo_pago_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($pagos as $pago)
						<option value="{{$pago->id}}">{{ $pago->tipo_pago}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div id='error_n' style="font-size:16px; font-weight:bold; color:green"> </div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("fecha","Fecha:") !!}
					{!! Form::date( "fecha" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("total","Total:") !!}
					{!! Form::text( "total" , null , ['class' => 'form-control' , 'placeholder' => 'Total' ]) !!}
				</div>
						
				
			</div>
			<br>
			<input type="hidden" name="serie" id="serie">

			
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/factura') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonFactura']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/facturas/create.js') !!}
@endsection