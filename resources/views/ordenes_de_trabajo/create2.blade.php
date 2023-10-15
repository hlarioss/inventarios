@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'OrdenDeTrabajoForm2') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Accesorios y Componetes </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
                    
                    <input type="checkbox" value="1" name="emblemas" id="emblemas">
                    {!! Form::label("emblemas","Emblemas") !!}
                </div>
				<div class="col-sm-4">
                    <input type="checkbox" value="1" name="encendedor" id="encendedor">
                    {!! Form::label("encendedor","Encendedor") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="espejos" id="espejos">
                    {!! Form::label("espejos","Espejos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="antena" id="antena">
                    {!! Form::label("antena","Antena") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="radio" id="radio">
                    {!! Form::label("radio","Radio") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="llavero" id="llavero">
                    {!! Form::label("llavero","Llavero") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="placas" id="placas">
                    {!! Form::label("placas","Placas") !!}
                </div>

                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="platos" id="platos">
                    {!! Form::label("platos","platos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="tapon_combustible" id="tapon_combustible">
                    {!! Form::label("tapon_combustible","Tapon de combustible") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="soporte_bateria" id="soporte_bateria">
                    {!! Form::label("soporte_bateria","Soporte de Bateria") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="papeles" id="papeles">
                    {!! Form::label("papeles","Papeles") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="alfombras" id="alfombras">
                    {!! Form::label("alfombras","Alfombras") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="control_alarma" id="control_alarma">
                    {!! Form::label("control_alarma","Control de Alarma") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="extinguidor" id="extinguidor">
                    {!! Form::label("extinguidor","Extinguidor") !!}
                </div>     
            
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="triangulos" id="triangulos">
                    {!! Form::label("triangulos","Triangulos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="vidrios_electricos" id="vidrios_electricos">
                    {!! Form::label("vidrios_electricos","Vidrios Electricos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="conos" id="conos">
                    {!! Form::label("conos","Conos") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="neblineras" id="neblineras">
                    {!! Form::label("neblineras","Neblineras") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="luces" id="luces">
                    {!! Form::label("luces","Luces") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="llanta_repuesto" id="llanta_repuesto">
                    {!! Form::label("llanta_repuesto","Llanta de Repuesto") !!}
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="llave_ruedas" id="llave_ruedas">
                    {!! Form::label("llave_ruedas","Llave de Ruedas") !!}
                </div>

                <div class="col-sm-4">
                    <input type="checkbox" value="1" name="tricket" id="tricket">
                    {!! Form::label("tricket","Tricket") !!}
                </div>
            </div>
			<br>
			<div class="col-sm-12">
                {!! Form::label("descripcion","Observaciones:") !!}<br>
                {!! Form::textarea( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones', 'rows'=> '5' ]) !!}
                
                
            </div>
			
			<br>
			<div class="row">
			<input name="orden_id" id="orden_id" class="hide" type="text" value="{{$orden_de_trabajo->id}}">
            </div>
            <hr>
                 <div class="row"> 
                     <div class="col-sm-3"></div>       
                <div class="col-sm-4" style="">
                    <input type="checkbox" name="combustible" style="position:absolute; top:230px; left:75px;" value="0" placeholder="E">
                    <input type="checkbox" name="combustible" style="position:absolute; top:210px; left:120px;" value="1" placeholder="1/8">
                    <input type="checkbox" name="combustible" style="position:absolute; top:190px; left:170px;" value="2" placeholder="1/4">
                    <input type="checkbox" name="combustible" style="position:absolute; top:180px; left:218px;" value="3" placeholder="3/8">
                    <input type="checkbox" name="combustible" style="position:absolute; top:178px; left:263px;" value="4" placeholder="1/2">
                    <input type="checkbox" name="combustible" style="position:absolute; top:183px; left:315px;" value="5" placeholder="5/8">
                    <input type="checkbox" name="combustible" style="position:absolute; top:193px; left:365px;" value="6" placeholder="3/4">
                    <input type="checkbox" name="combustible" style="position:absolute; top:215px; left:412px;" value="7" placeholder="7/8">
                    <input type="checkbox" name="combustible" style="position:absolute; top:240px; left:457px;" value="8" placeholder="Full">
                    <img src="/img/tanque.png" width="500" height="300">
                </div>
            </div>
            </div>
			<div class="text-right m-t-15">
                    <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ordenes_de_trabajo/edit/'.$orden_de_trabajo->id.'') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Siguiente', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonOrdenDeTrabajo2']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
</div>
@endsection

@section('scripts')

{!! HTML::script('/js/ordenes_de_trabajo/create2.js') !!}
@endsection