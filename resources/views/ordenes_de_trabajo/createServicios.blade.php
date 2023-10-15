@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Servicios solicitados</h3>
			</div>
			</div>
            <br>
				<div class="row">
					<div class="col-sm-3">
						<label for="servicio_id">Servicios</label>
						<select class="selectpicker" id='servicio_id' name="servicio_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
							<option value="0" selected="selected">Seleccione</option>
							@foreach ($servicios as $servicio)
							<option value="{{$servicio->id}}"><p id="servicio">{{$servicio->nombre}}</p> </option>
							@endforeach
						</select>
						<input type="number" name="subtotal" class="form-control hidden">
						<input type="text" name="orden_de_trabajo" class="form-control hidden" id="orden_id" value="{{$orden_de_trabajo->id}}">
					</div>

	
					<div class="col-sm-3">
						<label for="precio">Precio</label>
						<input type="text" name="precio" class="form-control" >	
					</div>

					<div class="col-sm-4">
						<label for="total">Mano de Obra:</label>
						<input type="text" name="mano_obra" class="form-control" id="mano_obra">
					</div>
				</div>
	
				<br>
		
					<div class="text-right m-t-15">
						{!! Form::button('Agregar Nuevo Servicio' , ['class' => 'btn btn-success' ,'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
					</div>

					<hr>

				<div id="serviciodetalle-grid"></div>

				<br>
				<div class="col-sm-4">
					<h3><label for="total">Total:</label></h3>
					<input type="text" name="total" class="form-control" id="total" readonly>
				</div>

				
			<br>
			<div class="text-right m-t-15">
					<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ordenes_de_trabajo/editcreate3/'.$orden_de_trabajo->id.'') }}">Regresar</a>
				<button type="submit" id="ButtonOrdenDeTrabajo" class="btn btn-primary form-gradient-color form-button">Guardar</button>
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	</div>
</div>
@endsection



@stack('scripts')

@section('scripts')
{!! HTML::script('/js/ordenes_de_trabajo/createServicios.js') !!}

@endsection