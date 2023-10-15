<div class="row">
    <div class="col-sm-12">
        <h3 class="tittle-custom"> Creación de Lineas de Vehiculo</h3>
        <line>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-4">
            {!! Form::label("linea","Linea:") !!}
            {!! Form::text( "linea" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre Linea' ]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label("marca_id","Marca:") !!}
            <select class="selectpicker" id='marca_id_linea' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione Marca">
                @foreach ($marcas as $marca)
                @if ($marca->tipo_marca_id==1 || $marca->tipo_marca_id==2 )
                <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <br>