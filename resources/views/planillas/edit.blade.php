@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($planilla, ['method' => 'PATCH', 'action' => ['PlanillasController@update', $planilla->id], 'id' => 'PlanillaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Planilla </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("fecha","Fecha:") !!}
                {!! Form::date( "fecha" , null , ['class' => 'form-control' , 'placeholder' => 'YYYY-MM-DD', 'id'=>'fecha' ]) !!}
            </div>
        </div>
        <br>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/planillas') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdatePlanilla']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/planillas/edit.js') !!}
@endsection
