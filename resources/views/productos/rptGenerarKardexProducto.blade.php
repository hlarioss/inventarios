@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array('class'=> 'form', 'id' => 'ReporteProductoForm', 'method' => 'POST', 'action' => ['ProductosController@rpt_kardex_producto'] ) ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Kardex de Productos </h3>
				<line>
			</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("producto_id","Producto:") !!}
					<select class="selectpicker" id='producto_id' name="producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($productos as $producto)
						<option value="{{$producto->id}}">{{$producto->nombre}}</option>
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
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/productos') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Generar Reporte', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonReporte', "formtarget" => "_ blank"]) !!}
			</div>
			<input type="hidden" name="_token" id="tokenReporte" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/productos/rptGenerarKardex.js') !!}
@endsection
