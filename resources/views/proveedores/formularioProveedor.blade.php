<div class="row">
    <div class="col-sm-12">
        <h3 class="tittle-custom"> Creación de Proveedores </h3>
        <line>
    </div>
</div>

<br>
<div class="row">
    <div class="col-sm-4">
        {!! Form::label("nit","NIT:") !!}
        {!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
    </div>
    <div class="col-sm-4">
        {!! Form::label("nombre","Nombres:") !!}
        {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}				
    </div>
    <div class="col-sm-4">
        {!! Form::label("tipo_proveedor_id","Tipo de Proveedor:") !!}
        <select class="selectpicker" id='tipo_proveedor_id' name="tipo_proveedor_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
            @foreach ($tipos_proveedores as $tipo_proveedor)
            <option value="{{$tipo_proveedor->id}}">{{$tipo_proveedor->nombre}}</option>
            @endforeach
        </select>
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col-sm-4">
        {!! Form::label("telefonos","Telefono:") !!}
        {!! Form::text( "telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Telefono' ]) !!}
    </div>
    <div class="col-sm-8">
        {!! Form::label("direccion","Dirección:") !!}
        {!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}			
    </div>
</div>