@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array('class'=> 'form', 'id' => 'ReporteForm', 'method' => 'POST', 'action' => ['CuentasPorPagarController@rpt_estado_cuenta_por_pagar'] ) ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Estado de Cuenta Proveedor </h3>
				<line>
			</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("proveedor_id","Proveedor:") !!}
						<select class="selectpicker" id='proveedor_id' name="proveedor_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
							@foreach ($proveedores as $proveedor)
							<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
							@endforeach
						</select>
                </div>
                <div class="col-sm-4">
					{!! Form::label("fecha_inicial","Fecha Inicial:") !!}
					{!! Form::date( "fecha_inicial" , null , ['class' => 'form-control' ]) !!}	
                </div>
                <div class="col-sm-4">
					{!! Form::label("fecha_final","Fecha Final:") !!}
					{!! Form::date( "fecha_final" , null , ['class' => 'form-control' ]) !!}	
				</div>
			</div>		
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/cuentas_por_pagar') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Generar Reporte', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonReporte', "formtarget" => "_ blank"]) !!}
			</div>
			<input type="hidden" name="_token" id="tokenReporte" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/cuentas_por_pagar/rptGenerar.js') !!}
@endsection
