<div class="row">
        <div class="col-sm-12">
            <h3 class="tittle-custom"> Creación de Vehiculos </h3>
            <line>
            </div>
        </div>
        <br>
        <!--	Primera linea de Vehiculos -->
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("placa","No Placa:") !!}
                {!! Form::text( "placa" , null , ['class' => 'form-control' , 'placeholder' => 'No Placa' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("tipo_vehiculo_id","Tipo de Vehiculo:") !!}
                <select class="selectpicker" id='tipo_vehiculo_id' name="tipo_vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_vehiculos as $tipo_vehiculo)
                    <option value="{{$tipo_vehiculo->id}}">{{$tipo_vehiculo->nombre}}</option>							
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("marca_id","Marca:") !!}
                <select class="form-control" id='marca_id' name="marca_id" value="" data-live-search-placeholder="Búsqueda" title="Seleccione">
                </select>
                @if(request()->is('vehiculos/new*'))
                
                <button class="btn btn-primary pull-right btn-sm" data-toggle="modal" data-target="#marcaModal" id="marcaModal" type="button">
                    <i class="fa fa-plus"></i>Nueva Marca</button> 
                
                @endif
            </div>
            <div class="col-sm-3" >
                {!! Form::label("linea_id","Linea:") !!}
                <br>
                <select  class="form-control" id='linea_id' name="linea_id" value="" data-live-search-placeholder="Búsqueda">
                </select>
                @if(request()->is('vehiculos/new*'))
                <button class="btn btn-primary pull-right btn-sm" data-toggle="modal" data-target="#lineaModal" id="lineaModal" type="button">
                <i class="fa fa-plus"></i>Nueva Linea</button>
                @endif

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
                        <option value="{{$anio}}">  {{$anio}}  </option>
                    @endfor
                </select>
            </div>
            
            <div class="col-sm-3">
                {!! Form::label("color_id","Color:") !!}
                <select class="selectpicker" id='color_id' name="color_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($colores as $color)
                    <option value="{{$color->id}}"> {{$color->color}} </option>							
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
            <div class="col-sm-3">
                {!! Form::label("vin","VIN:") !!}
                {!! Form::text( "vin" , null , ['class' => 'form-control' , 'placeholder' => 'VIN' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("direccion_id","Tipo de Direccion:") !!}
                <select class="selectpicker" id='direccion_id' name="direccion_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($direcciones as $direccion)
                    <option value="{{$direccion->id}}">{{$direccion->tipo_direccion}}</option>							
                    @endforeach
                </select>
            </div>	
            <div class="col-sm-6">
                {!! Form::label("cliente_id","Dueño:") !!}
                <select class="form-control" name="cliente_id" id="cliente_id_vehiculo" value="" data-live-search-placeholder="Búsqueda" title="Seleccione">
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
                    <option value="{{$tipo_transmision->id}}">{{$tipo_transmision->transmision}}</option>							
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("traccion_id","Tipo de Tracción:") !!}
                <select class="selectpicker" id='traccion_id' name="traccion_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tracciones as $traccion)
                    <option value="{{$traccion->id}}">{{$traccion->traccion}}</option>							
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("direfenciales","Diferenciales:") !!}
                <input type="text" name="diferenciales" id="diferenciales" class='form-control disabled' placeholder="Diferencial">
                
            </div>
            <div class="col-sm-3">
                {!! Form::label("tipo_caja_id","Tipo de Caja:") !!}
                <select  class="form-control" id='tipo_caja_id' name="tipo_caja_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda">

                </select>
            </div>		
        </div>
        <br>
        <!--	segunda linea de transmision -->
        <br>
        <div class="row">
            
            <div class="col-sm-3">
                {!! Form::label("aceite_caja_fabrica","Aceite de caja de Fabrica:") !!}
                {!! Form::text( "aceite_caja_fabrica" , null , ['class' => 'form-control' , 'placeholder' => 'Aceite de Caja Según Fabricante', 'id' => 'aceite_caja_2' ]) !!}
                
            </div>
            <div class="col-sm-3">
                {!! Form::label("aceite_caja","Aceite De Caja:") !!}
                <input type="text" name="aceite_caja" id="aceite_caja" class='form-control disabled' placeholder="Viscosidad">
                
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
                    <option value="{{$combustible->id}}">{{$combustible->combustible}}</option>							
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