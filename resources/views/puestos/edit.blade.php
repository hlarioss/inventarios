@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($puesto, ['method' => 'PATCH', 'action' => ['PuestosController@update', $puesto->id], 'id' => 'PuestoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de puesto </h3>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-sm-4">
                    {!! Form::label("nombre","Puesto:") !!}
                    {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'puesto' ]) !!}
                </div>

                <div class="col-sm-4">
                        {!! Form::label("sueldo","Sueldo:") !!}
                        {!! Form::text( "sueldo" , null , ['class' => 'form-control' , 'placeholder' => 'sueldo' ]) !!}
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/puestos') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdatePuesto']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/puestos/edit.js') !!}
@endsection