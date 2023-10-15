@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
        
        {!! Form::model($orden, ['method' => 'PATCH', 'action' => ['OrdenesDeTrabajoController@update2', $orden->id], 'id' => 'CreateUpdateForm2']) !!}
        <div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Accesorios y Componetes </h3>
				<line>
				</div>
			</div>
            <br>
			<div class="row">
            @foreach ($componentes as $componente)
                <div class="col-sm-4">
                
                    <input type="checkbox" value="1" id="1" name="emblemas" id="emblemas" {{$componente->emblemas == 1 ? 'checked': ''}}>
                    {!! Form::label("emblemas","Emblemas") !!}
                </div>
				<div class="col-sm-4">
                    <input type="checkbox" value="1" id="2" name="encendedor" {{$componente->encendedor == 1 ? 'checked': ''}} id="encendedor">
                    {!! Form::label("encendedor","Encendedor") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="3" name="espejos" {{$componente->espejos == 1 ? 'checked': ''}} id="espejos">
                    {!! Form::label("espejos","Espejos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="4" name="antena" {{$componente->antena == 1 ? 'checked': ''}} id="antena">
                    {!! Form::label("antena","Antena") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="5" name="radio" {{$componente->radio == 1 ? 'checked': ''}} id="radio">
                    {!! Form::label("radio","Radio") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="6" name="llavero" {{$componente->llavero == 1 ? 'checked': ''}} id="llavero">
                    {!! Form::label("llavero","Llavero") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="7" name="placas" {{$componente->placas == 1 ? 'checked': ''}} id="placas">
                    {!! Form::label("placas","Placas") !!}
                </div>

                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="8" name="platos" {{$componente->platos == 1 ? 'checked': ''}} id="platos">
                    {!! Form::label("platos","platos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="9" name="tapon_combustible" {{$componente->tapon_combustible == 1 ? 'checked': ''}} id="tapon_combustible">
                    {!! Form::label("tapon_combustible","Tapon de combustible") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="10" name="soporte_bateria" {{$componente->soporte_bateria == 1 ? 'checked': ''}} id="soporte_bateria">
                    {!! Form::label("soporte_bateria","Soporte de Bateria") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="11" name="papeles" {{$componente->papeles == 1 ? 'checked': ''}} id="papeles">
                    {!! Form::label("papeles","Papeles") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="12" name="alfombras" {{$componente->alfombras == 1 ? 'checked': ''}} id="alfombras">
                    {!! Form::label("alfombras","Alfombras") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="13" name="control_alarma" {{$componente->control_alarma == 1 ? 'checked': ''}} id="control_alarma">
                    {!! Form::label("control_alarma","Control de Alarma") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="14" name="extinguidor" {{$componente->extinguidor == 1 ? 'checked': ''}} id="extinguidor">
                    {!! Form::label("extinguidor","Extinguidor") !!}
                </div>     
            
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="15" name="triangulos" {{$componente->triangulos == 1 ? 'checked': ''}} id="triangulos">
                    {!! Form::label("triangulos","Triangulos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="16" name="vidrios_electricos" {{$componente->vidrios_electricos == 1 ? 'checked': ''}} id="vidrios_electricos">
                    {!! Form::label("vidrios_electricos","Vidrios Electricos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="17" name="conos" {{$componente->conos == 1 ? 'checked': ''}} id="conos">
                    {!! Form::label("conos","Conos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="18" name="neblineras" {{$componente->neblineras == 1 ? 'checked': ''}} id="neblineras">
                    {!! Form::label("neblineras","Neblineras") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="19" name="luces" {{$componente->luces == 1 ? 'checked': ''}} id="luces">
                    {!! Form::label("luces","Luces") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="20" name="llanta_repuesto" {{$componente->llanta_repuesto == 1 ? 'checked': ''}} id="llanta_repuesto">
                    {!! Form::label("llanta_repuesto","Llanta de Repuesto") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="21" name="llave_ruedas" {{$componente->llave_ruedas == 1 ? 'checked': ''}} id="llave_ruedas">
                    {!! Form::label("llave_ruedas","Llave de Ruedas") !!}
                </div>

                <div class="col-sm-4">
                    <input type="checkbox" value="1" id="22" name="tricket" {{$componente->tricket == 1 ? 'checked': ''}} id="tricket">
                    {!! Form::label("tricket","Tricket") !!}
                </div>
                
            </div>
            <br>
            
			<div class="col-sm-12">
                {!! Form::label("descripcion","Observaciones:") !!}
                {!! Form::textarea("descripcion" ,$componente->descripcion  , ['class' => 'form-control' , 'placeholder' => 'Observaciones', 'rows'=> '5', 'id'=>'descripcion' ]) !!}
                  
            </div>
            @endforeach
            
			<br>
			<div class="row">
			<input name="orden_id" id="orden_id" class="hide" type="text" value="{{$orden->id}}">
            </div>
            <hr>
                 <div class="row"> 
                     <div class="col-sm-3"></div>       
                <div class="col-sm-4" style="">
                    @foreach ($componentes as $componente)
                    <input type="checkbox" id="c0" name="combustible" style="position:absolute; top:230px; left:75px;" value="0" placeholder="E" {{$componente->combustible == 0 ? 'checked': ''}}>
                    <input type="checkbox" id="c1" name="combustible" style="position:absolute; top:210px; left:120px;" value="1" placeholder="1/8" {{$componente->combustible == 1 ? 'checked': ''}}>
                    <input type="checkbox" id="c2" name="combustible" style="position:absolute; top:190px; left:170px;" value="2" placeholder="1/4" {{$componente->combustible == 2 ? 'checked': ''}}>
                    <input type="checkbox" id="c3" name="combustible" style="position:absolute; top:180px; left:218px;" value="3" placeholder="3/8" {{$componente->combustible == 3 ? 'checked': ''}}>
                    <input type="checkbox" id="c4" name="combustible" style="position:absolute; top:178px; left:263px;" value="4" placeholder="1/2" {{$componente->combustible == 4 ? 'checked': ''}}>
                    <input type="checkbox" id="c5" name="combustible" style="position:absolute; top:183px; left:315px;" value="5" placeholder="5/8" {{$componente->combustible == 5 ? 'checked': ''}}>
                    <input type="checkbox" id="c6" name="combustible" style="position:absolute; top:193px; left:365px;" value="6" placeholder="3/4" {{$componente->combustible == 6 ? 'checked': ''}}>
                    <input type="checkbox" id="c7" name="combustible" style="position:absolute; top:215px; left:412px;" value="7" placeholder="7/8" {{$componente->combustible == 7 ? 'checked': ''}}>
                    <input type="checkbox" id="c8" name="combustible" style="position:absolute; top:240px; left:457px;" value="8" placeholder="Full" {{$componente->combustible == 8 ? 'checked': ''}}>
                    <img src="/img/tanque.png" width="500" height="300">
                    @endforeach
                </div>
            </div>
            </div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ordenes_de_trabajo/edit/'.$orden->id.'') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Siguiente', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonOrdenDeTrabajoupdate2']) !!}
			</div>
        <br>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		{!! Form::close() !!}
</div>
@endsection
@section('scripts')
{!! HTML::script('/js/ordenes_de_trabajo/editcreate2.js') !!}

@endsection