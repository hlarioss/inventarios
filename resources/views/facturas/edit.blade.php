@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($factura, ['method' => 'PATCH', 'action' => ['FacturasController@update', $factura->id], 'id' => 'FacturaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Facturas </h3>
            </div>
        </div>
        <br>
        <div class="row">
				<div class="col-sm-4">
						{!! Form::label("serie_id","Serie:") !!}
						<select class="selectpicker" id='serie_id' name="serie_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
							@foreach ($series as $serie)
								@if ( $serie->id == $factura->serie_id)
									<option value="{{$serie->id}}" selected>{{ $serie->serie}}</option>
								@else
								@if($serie->documento_id == 1 && $serie->estado_id == 2)
									<option value="{{$serie->id}}">{{ $serie->serie}}</option>@endif
								@endif
							@endforeach
						</select>
					</div>		
				
				<div class="col-sm-4 form-group ">
					{!! Form::label("numero","Numero:") !!}
					{!! Form::text( "numero" , null , ['class' => 'form-control' , 'placeholder' => 'Numero:','id'=>'numero_f' ]) !!}	
				</div>
				<div class="col-sm-4">
					{!! Form::label("tipo_pago_id","Tipo de Pago:") !!}
					<select class="selectpicker" id='tipo_pago_id' name="tipo_pago_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($pagos as $pago)
						@if ( $pago->id == $factura->tipo_pago_id)
						<option value="{{$pago->id}}" selected>{{ $pago->tipo_pago}}</option>
						@else
						<option value="{{$pago->id}}">{{ $pago->tipo_pago}}</option>
						@endif
						@endforeach
					</select>
				</div>
		</div>
		<div id='error_n' style="font-size:16px; font-weight:bold; color:green"> </div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("fecha","Fecha:") !!}
					{!! Form::date( "fecha" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha:' ]) !!}
				</div>
				
				
				<div class="col-sm-4">
					{!! Form::label("total","Total:") !!}
					{!! Form::text( "total" , null , ['class' => 'form-control' , 'placeholder' => 'Total' ]) !!}
				</div>
	
			</div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/factura') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateFactura']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/facturas/edit.js') !!}
@endsection