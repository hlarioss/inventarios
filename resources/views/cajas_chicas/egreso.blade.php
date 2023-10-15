@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array('class'=> 'form', 'id' => 'EgresoForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación Egreso Caja Chica </h3>
				<line>
			</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("documento","Documento:") !!}
					{!! Form::text( "documento" , null , ['class' => 'form-control' , 'placeholder' => 'Documento' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("descripcion","Descripcion:") !!}
					{!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion' ]) !!}
                </div>
                <div class="col-sm-4">
					{!! Form::label("total","Total:") !!}
					{!! Form::number( "total" , null , ['class' => 'form-control' , 'placeholder' => 'Total' ]) !!}	
				</div>
			</div>			
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/cajas_chicas') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonEgreso']) !!}
			</div>
			<input type="hidden" name="_token" id="tokenEgreso" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/cajas_chicas/create.js') !!}
@endsection