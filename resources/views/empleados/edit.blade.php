@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($empleado, ['method' => 'PATCH', 'action' => ['EmpleadosController@update', $empleado->id], 'id' => 'EmpleadoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Empleado </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4 {{$errors->has('emp_cui')? 'has-error' : ''}}">
                {!! Form::label("emp_cui","CUI/DPI:") !!}
                {!! Form::text( "emp_cui" , null , ['class' => 'form-control' , 'placeholder' => 'CUI/DPI' ]) !!}
                {!!$errors->first('emp_cui', '<label class="error">:message</label>')!!}
            </div>
           <div class="col-sm-4"></div>               
            <div class="col-sm-4">
                {!! Form::label("puesto_id","Puesto del Empleado:") !!}
                <select class="selectpicker" id='puesto_id' name="puesto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($puestos as $puesto)
                    @if ( $puesto->id == $empleado->puesto_id)
                    <option value="{{$puesto->id}}" selected>{{ $puesto->nombre}}</option>
                    @else
                    <option value="{{$puesto->id}}">{{ $puesto->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label("nombre","Nombres:") !!}
                {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}
            </div>
            <div class="col-sm-6">
                {!! Form::label("apellido","Apellidos:") !!}
                {!! Form::text( "apellido" , null , ['class' => 'form-control' , 'placeholder' => 'Apellidos' ]) !!}
            </div>
        </div>
        <br>
 
        <br>

        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("telefono","Teléfono:") !!}
                {!! Form::number( "telefono" , null , ['class' => 'form-control' , 'placeholder' => 'Telefono' ]) !!}
            </div>
            <div class="col-sm-4 {{$errors->has('nit')? 'has-error' : ''}}">
                {!! Form::label("nit","NIT:") !!}
                {!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
                {!!$errors->first('nit', '<label class="error">:message</label>')!!}
            </div>
                 
            <div class="col-sm-2">
                {!! Form::label("fecha_inicio","Fecha Inicio:") !!}
                {!! Form::date( "fecha_inicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fec Inicio' ]) !!}
            </div>
            <div class="col-sm-2">
                {!! Form::label("fecha_nacimiento","Fecha Nacimiento:") !!}
                {!! Form::date( "fecha_nacimiento" , null , ['class' => 'form-control' , 'placeholder' => 'Fec Nacimiento' ]) !!}
            </div>

        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("direccion","Dirección:") !!}
                {!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/empleados') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateEmpleado']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/empleados/edit.js') !!}
@endsection