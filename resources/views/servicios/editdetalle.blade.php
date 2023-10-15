@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($detalle, ['method' => 'PATCH', 'action' => ['ServiciosController@updateDetalle', $detalle->id], 'id' => 'DetalleUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de detalle </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                @if($detalle->maquinaria_equipo_id)
                {!! Form::label("maquinaria_equipo_id","Maquinaria y/o Equipo:") !!}
                <select class="selectpicker" id='maquinaria_equipo_id' name="maquinaria_equipo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($maquinarias as $maquinaria)
                    @if($maquinaria->id == $detalle->maquinaria_equipo_id)
                    <option value="{{$maquinaria->id}}" selected>{{$maquinaria->nombre_maquina}}</option>
                    @else
                    <option value="{{$maquinaria->id}}">{{$maquinaria->nombre_maquina}}</option>
                    @endif							
                    @endforeach
                </select>
                @else
                {!! Form::label("producto_id","Producto:") !!}
                <select class="selectpicker" id='producto_id' name="producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($productos as $producto)
                    @if($producto->id == $detalle->producto_id)
                    <option value="{{$producto->id}}" selected>{{$producto->nombre}}</option>
                    @else
                    <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                    @endif							
                    @endforeach
                </select>
                @endif
            </div>
            <div class="col-sm-3">
                {!! Form::label("costo","Costo:") !!}
                {!! Form::number( "costo" , null , ['class' => 'form-control' , 'placeholder' => 'Costo' ]) !!}

            </div>
            <div class="col-sm-3">
                {!! Form::label("cantidad","Cantidad:") !!}
                {!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("subtotal","Subtotal:") !!}
                {!! Form::text( "subtotal" , $detalle->costo * $detalle->cantidad , ['class' => 'form-control' , 'placeholder' => 'Cantidad', 'disabled' => 'true' ]) !!}
            </div>
            
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/servicios') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateDetalle']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/servicios/editdetalle.js') !!}
@endsection