@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'SerieForm')) !!} -->
		{!! Form::open( array( 'id' => 'SerieForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Series de Documentos </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4 form-group ">
					{!! Form::label("resolucion","Resolucion:") !!}
					{!! Form::text( "resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Resolucion:' ]) !!}
					
				</div>
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					{!! Form::label("serie","Serie:") !!}
					{!! Form::text( "serie" , null , ['class' => 'form-control' , 'placeholder' => 'Serie:' ]) !!}
				</div>
				
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("fecha_resolucion","Fecha Resolucion:") !!}
					{!! Form::date( "fecha_resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Resolucion' ]) !!}
				</div>
				
				<div class="col-sm-6">
					{!! Form::label("fecha_vencimiento","Fecha de Vencimiento:") !!}
					{!! Form::date( "fecha_vencimiento" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Vencimiento' ]) !!}
				</div>
				
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("documento_id","Documento:") !!}
					<select class="selectpicker" id='documento_id' name="documento_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($documentos as $documento)
						<option value="{{$documento->id}}">{{ $documento->descripcion}}</option>
						@endforeach
					</select>
				</div>
						
				<div class="col-sm-4">
					{!! Form::label("inicio","Numero Inicio:") !!}
					{!! Form::number( "inicio" , null , ['class' => 'form-control' , 'placeholder' => 'Numero Inicio', 'id' => 'inicio', 'disabled' => true ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("fin","Numero Fin:") !!}
					{!! Form::number( "fin" , null , ['class' => 'form-control' , 'placeholder' => 'Numero Fin', 'disabled' => true ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/series') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonSerie']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/series/create.js') !!}
@endsection