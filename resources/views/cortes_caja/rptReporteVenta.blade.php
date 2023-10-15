@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'ReporteForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Reporte de Venta General Por Fecha </h3>
				<line>
			</div>
		</div>
			<br>
			<div class="row">
                <div class="col-sm-6">
					{!! Form::label("fecha_inicial","Fecha Inicial:") !!}
					{!! Form::date( "fecha_inicial" , null , ['class' => 'form-control','id'=>'inicial' ]) !!}	
                </div>
                <div class="col-sm-6">
					{!! Form::label("fecha_final","Fecha Final:") !!}
					{!! Form::date( "fecha_final" , null , ['class' => 'form-control','id'=>'final' ]) !!}	
				</div>
			</div>		
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/productos') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Generar Reporte', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonReporte']) !!}
			</div>
			<input type="hidden" name="_token" id="tokenReporte" value="{{ csrf_token() }}">
		<br>

		{!! Form::close() !!}
		<div class="panel panel-body">
			<table id="Reporte-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">
			</table>
		</div>
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/cortes_caja/rptGenerarReporte.js') !!}
@endsection
