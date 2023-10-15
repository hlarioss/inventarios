@extends('layouts.app')
@section('content')

<div id="content">
    <div class="container-custom">

    {!! Form::model($vehiculo, ['method' => 'PATCH', 'action' => ['VehiculosController@update', $vehiculo->id], 'id' => 'VehiculoUpdateForm']) !!}

    <div class="row">
        <div class="col-sm-12">
            <h3 class="tittle-custom"> Edición de Vehiculos </h3>
        </div>
    </div>
    <br>
        <!--	Primera linea de Vehiculos -->
        <div class="row">
            <div class="col-sm-3 {{$errors->has('placa')? 'has-error' : ''}}">
                {!! Form::label("placa","No Placa:") !!}
                {!! Form::text( "placa" , null , ['class' => 'form-control' , 'placeholder' => 'No Placa' ]) !!}
                {!!$errors->first('placa', '<label class="error">:message</label>')!!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("tipo_vehiculo_id","Tipo de Vehiculo:") !!}
                <select class="selectpicker" id='tipo_vehiculo_id' name="tipo_vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_vehiculos as $tipo_vehiculo)
                    @if ( $tipo_vehiculo->id == $vehiculo->tipo_vehiculo_id)
                    <option value="{{$tipo_vehiculo->id}}" selected>{{ $tipo_vehiculo->nombre}}</option>
                    @else
                    <option value="{{$tipo_vehiculo->id}}">{{ $tipo_vehiculo->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("marca_id","Marca:") !!}
                <select class="selectpicker" id='marca_id' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($marcas as $marca)
                    @if ( $marca->id == $vehiculo->marca_id)
                    <option value="{{$marca->id}}" selected>{{ $marca->nombre}}</option>
                    @else
                    <option value="{{$marca->id}}">{{ $marca->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3" >
                {!! Form::label("linea_id","Linea:") !!}
                <br>
                <select  class="form-control" id='linea_id' name="linea_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda">
                    @foreach ($lineas as $linea)
                    @if ( $linea->id == $vehiculo->linea_id)
                        <option value="{{$linea->id}}"selected> {{$linea->linea}} </option>	
                    @else
                        <option value="{{$linea->id}}"> {{$linea->linea}} </option>							
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        
        <!--	Segunda linea de Vehiculos -->
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("kilometraje","Kilometraje:") !!}
                {!! Form::number( "kilometraje" , null , ['class' => 'form-control' , 'placeholder' => 'Kilometraje' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("anio","Año:") !!}
                <select class="selectpicker" id='anio' name="anio" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Año">
                    @for($anio=(date("Y")+1); 1980<=$anio; $anio--)
                    @if ( $anio == $vehiculo->anio)
                    <option value="{{$anio}}"selected>  {{$anio}}  </option>
                    @else 
                    <option value="{{$anio}}">  {{$anio}}  </option>
                    @endif
                    @endfor
                </select>
            </div>
            
            <div class="col-sm-3">
                {!! Form::label("color_id","Color:") !!}
                <select class="selectpicker" id='color_id' name="color_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($colores as $color)
                    @if ( $color->id == $vehiculo->color_id)
                        <option value="{{$color->id}}"selected> {{$color->color}} </option>	
                    @else
                        <option value="{{$color->id}}"> {{$color->color}} </option>							
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("fecha_ultimo_servicio","Fecha Ultimo Servicio:") !!}
                {!! Form::date( "fecha_ultimo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Ultimo Servicio' ]) !!}
            </div>
        </div>
        <br>
        <!--	Tercera linea de Vehiculos -->
        <div class="row">
            <div class="col-sm-3 {{$errors->has('vin')? 'has-error' : ''}}">
                {!! Form::label("vin","VIN:") !!}
                {!! Form::text( "vin" , null , ['class' => 'form-control' , 'placeholder' => 'VIN' ]) !!}
                {!!$errors->first('vin', '<label class="error">:message</label>')!!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("direccion_id","Tipo de Direccion:") !!}
                <select class="selectpicker" id='direccion_id' name="direccion_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($direcciones as $direccion)
                    @if ( $direccion->id == $vehiculo->direccion_id)
                    <option value="{{$direccion->id}}" selected >{{$direccion->tipo_direccion}}</option>
                    @else
                    <option value="{{$direccion->id}}">{{$direccion->tipo_direccion}}</option>							
                    @endif
                    @endforeach
                </select>
            </div>	
            <div class="col-sm-6">
                {!! Form::label("cliente_id","Dueño:") !!}
                <select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($clientes as $cliente)
                    @if ( $cliente->id == $vehiculo->cliente_id)
                    <option value="{{$cliente->id}}" selected>{{ $cliente->nombres.' '.$cliente->apellidos}}</option>
                    @else
                    <option value="{{$cliente->id}}">{{ $cliente->nombres.' '.$cliente->apellidos}}</option>
                    @endif
                    @endforeach
                </select>
            </div>	
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="tittle"> Transmision</h4>
                <line>
            </div>
        </div>
        <br>
        <!--	primera linea de transmision -->
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("transmision_id","Tipo de Transmisión:") !!}
                <select class="selectpicker" id='transmision_id' name="transmision_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_transmision as $tipo_transmision)
                    @if ( $tipo_transmision->id == $vehiculo->transmision_id)
                    <option value="{{$tipo_transmision->id}}" selected>{{ $tipo_transmision->transmision}}</option>
                    @else
                    <option value="{{$tipo_transmision->id}}">{{ $tipo_transmision->transmision}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("traccion_id","Tipo de Tracción:") !!}
                <select class="selectpicker" id='traccion_id' name="traccion_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tracciones as $traccion)
                    @if ( $traccion->id == $vehiculo->traccion_id)
                    <option value="{{$traccion->id}}"selected>{{$traccion->traccion}}</option>
                    @else
                    <option value="{{$traccion->id}}">{{$traccion->traccion}}</option>							
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("direfenciales","Diferenciales:") !!}
                {!! Form::text( "diferenciales" , null , ['class' => 'form-control' , 'placeholder' => 'diferenciales','id'=>"diferenciales" ]) !!}
                
                
            </div>
            <div class="col-sm-3">
                {!! Form::label("tipo_caja_id","Tipo de Caja:") !!}
                <select  class="form-control" id='tipo_caja_id' name="tipo_caja_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda">
                    @foreach ($tipos_caja as $caja)
                    @if ( $caja->id == $vehiculo->caja_id)
                        <option value="{{$caja->id}}"selected> {{$caja->tipo_caja}} </option>	
                    @else
                        <option value="{{$caja->id}}"> {{$caja->tipo_caja}} </option>							
                    @endif
                    @endforeach
                </select>
            </div>		
        </div>
        <br>
        <!--	segunda linea de transmision -->
        <br>
        <div class="row">
            
            <div class="col-sm-3">
                {!! Form::label("aceite_caja_fabrica","Aceite de caja de Fabrica:") !!}
                {!! Form::text( "aceite_caja_fabrica" , null , ['class' => 'form-control' , 'placeholder' => 'Aceite de Caja Según Fabricante' ]) !!}
                
            </div>
            <div class="col-sm-3">
                {!! Form::label("aceite_caja","Aceite De Caja:") !!}
                {!! Form::text( "aceite_caja" , null , ['class' => 'form-control' , 'id'=>'aceite_caja','placeholder' => 'Aceite de caja' ]) !!}
  
                
            </div>
            <div class="col-sm-3">
                {!! Form::label("cantidad_aceite_caja","Cantidad:") !!}
                {!! Form::text( "cantidad_aceite_caja" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad de Aceite' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("viscosidad_caja","Viscosidad:") !!}
                {!! Form::text( "viscosidad_caja" , null , ['class' => 'form-control' , 'placeholder' => 'Viscosidad' ]) !!}
                
            </div>
        
        </div>
        <!--	Primera linea de Motor -->
        <br>
        <br>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="tittle"> Motor</h4>
                <line>
            </div>
        </div>
        <br>
        <div class="row">
            
            <div class="col-sm-3">
                {!! Form::label("combustible_id","Combustible:") !!}
                <select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($combustibles as $combustible)
                    @if ( $combustible->id == $vehiculo->combustible_id)
                    <option value="{{$combustible->id}}"selected>{{$combustible->combustible}}</option>
                    @else
                    <option value="{{$combustible->id}}">{{$combustible->combustible}}</option>							
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("no_motor","No. Motor:") !!}
                {!! Form::text( "no_motor" , null , ['class' => 'form-control' , 'placeholder' => 'No. Motor' ]) !!}
                
            </div>
            <div class="col-sm-3">
                {!! Form::label("ccs","CC´s:") !!}
                {!! Form::text( "ccs" , null , ['class' => 'form-control' , 'placeholder' => 'CC´s' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("cilindros","Cilindros:") !!}
                {!! Form::text( "cilindros" , null , ['class' => 'form-control' , 'placeholder' => 'Cilindros de Aceite' ]) !!}
            </div>
    
        </div>
        <!--	segunda linea de motor -->
        <br>
        <div class="row">
            
            <div class="col-sm-3">
                {!! Form::label("aceite_motor_fabrica","Aceite de motor de Fabrica:") !!}
                {!! Form::text( "aceite_motor_fabrica" , null , ['class' => 'form-control' , 'placeholder' => 'Aceite de Motor Según Fabricante' ]) !!}
                
            </div>
            <div class="col-sm-3">
                {!! Form::label("aceite_motor","Aceite De Motor:") !!}
                {!! Form::text( "aceite_motor" , null , ['class' => 'form-control' , 'placeholder' => 'Aceite De Motor que Usa' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("cantidad_aceite_motor","Cantidad:") !!}
                {!! Form::text( "cantidad_aceite_motor" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad de Aceite' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("viscosidad_motor","Viscosidad:") !!}
                {!! Form::text( "viscosidad_motor" , null , ['class' => 'form-control' , 'placeholder' => 'Viscosidad' ]) !!}
            </div>
        
        </div>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("observaciones","Observacciones Generales:") !!}
                {!! Form::textarea( "observaciones" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones de Generales', 'rows'=> '5' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/vehiculos') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateVehiculo']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts')
{!! HTML::script('/js/vehiculos/edit.js') !!}
@endsection