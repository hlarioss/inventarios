@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
        {!! Form::model($orden, ['method' => 'PATCH', 'action' => ['OrdenesDeTrabajoController@update3', $orden->id], 'id' => 'CreateUpdateForm3']) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Golpes y Abollones</h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
			<input name="orden_id" id="orden_id" class="hide" type="text" value="{{$orden->id}}">
            </div>
            <hr>
                <div class="row">
                    @foreach ($golpes as $golpe)
                              
                    <div class="col-sm-3">
                        <!-- imagen frente 1 -->
                        <input type="checkbox" id="1" name="img1_1" style="position:absolute; top:35px; left:35px;" {{$golpe->img1_1 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="2" name="img1_2" style="position:absolute; top:40px; left:70px;" {{$golpe->img1_2 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="3" name="img1_3" style="position:absolute; top:40px; left:100px;" {{$golpe->img1_3 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="4" name="img1_4" style="position:absolute; top:60px; left:35px;" {{$golpe->img1_4 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="5" name="img1_5" style="position:absolute; top:60px; left:70px;" {{$golpe->img1_5 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="6" name="img1_6" style="position:absolute; top:60px; left:100px;" {{$golpe->img1_6 == 1 ? 'checked': ''}} value="1" >
                        <!-- imagen tracera 1 -->
                        <input type="checkbox" id="7" name="img1_7" style="position:absolute; top:35px; left:165px;" {{$golpe->img1_7 == 1 ? 'checked': ''}} value="1">
                        <input type="checkbox" id="8" name="img1_8" style="position:absolute; top:35px; left:200px;" {{$golpe->img1_8 == 1 ? 'checked': ''}} value="1">
                        <input type="checkbox" id="9" name="img1_9" style="position:absolute; top:37px; left:230px;" {{$golpe->img1_9 == 1 ? 'checked': ''}} value="1">
                        <input type="checkbox" id="10" name="img1_10" style="position:absolute; top:65px; left:160px;" {{$golpe->img1_10 == 1 ? 'checked': ''}} value="1">
                        <input type="checkbox" id="11" name="img1_11" style="position:absolute; top:65px; left:200px;" {{$golpe->img1_11 == 1 ? 'checked': ''}} value="1">
                        <input type="checkbox" id="12" name="img1_12" style="position:absolute; top:65px; left:235px;" {{$golpe->img1_12 == 1 ? 'checked': ''}} value="1">
                        
                        
                        <img src="/img/imagen1.png" width="250">
                    </div>
                                        
                    <div class="col-sm-3">
                        <!-- imagen costado 1 -->
                        <input type="checkbox" id="13" name="img2_1" style="position:absolute; top:25px; left:45px;" {{$golpe->img2_1 == 1 ? 'checked': ''}}  value="1" >
                        <input type="checkbox" id="14" name="img2_2" style="position:absolute; top:40px; left:30px;" {{$golpe->img2_2 == 1 ? 'checked': ''}}  value="1" >
                        <input type="checkbox" id="15" name="img2_3" style="position:absolute; top:40px; left:100px;" {{$golpe->img2_3 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="16" name="img2_4" style="position:absolute; top:40px; left:150px;" {{$golpe->img2_4 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="17" name="img2_5" style="position:absolute; top:25px; left:200px;" {{$golpe->img2_5 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="18" name="img2_6" style="position:absolute; top:45px; left:240px;" {{$golpe->img2_6 == 1 ? 'checked': ''}} value="1" >    
                        <img src="/img/imagen2.png" width="250">
                    </div>
                    <div class="col-sm-3">
                        <!-- imagen costado 2 -->
                        <input type="checkbox" id="19" name="img3_1" style="position:absolute; top:50px; left:30px;" {{$golpe->img3_1 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="20" name="img3_2" style="position:absolute; top:32px; left:55px;" {{$golpe->img3_2 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="21" name="img3_3" style="position:absolute; top:40px; left:120px;" {{$golpe->img3_3 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="22" name="img3_4" style="position:absolute; top:40px; left:170px;" {{$golpe->img3_4 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="23" name="img3_5" style="position:absolute; top:25px; left:220px;" {{$golpe->img3_5 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="24" name="img3_6" style="position:absolute; top:45px; left:240px;" {{$golpe->img3_6 == 1 ? 'checked': ''}} value="1" >    
                        <img src="/img/imagen3.png" width="250">
                    </div>
                    <div class="col-sm-3">
                        <!-- imagen arriba 1 -->
                        <input type="checkbox" id="25" name="img4_1" style="position:absolute; top:12px; left:35px;" {{$golpe->img4_1 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="26" name="img4_2" style="position:absolute; top:43px; left:35px;" {{$golpe->img4_2 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="27" name="img4_3" style="position:absolute; top:83px; left:35px;" {{$golpe->img4_3 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="28" name="img4_4" style="position:absolute; top:45px; left:60px;" {{$golpe->img4_4 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="29" name="img4_5" style="position:absolute; top:45px; left:120px;" {{$golpe->img4_5 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="30" name="img4_6" style="position:absolute; top:45px; left:170px;" {{$golpe->img4_6 == 1 ? 'checked': ''}} value="1" >
                        <img src="/img/imagen4.png" width="250">
                    </div>

                    @endforeach
                </div>
        <br>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		{!! Form::close() !!}
        <br>
        {!! Form::model($orden, ['method' => 'PATCH', 'action' => ['OrdenesDeTrabajoController@update4', $orden->id], 'id' => 'CreateUpdateForm4']) !!}
        
        <div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Raspones</h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
			<input name="orden_id" id="orden_id" class="hide" type="text" value="{{$orden->id}}">
            </div>
            <hr>
                <div class="row">
                    @foreach ($rayones as $rayon)
                        
                    
                    <div class="col-sm-3">
                        <!-- imagen frente 1 -->
                        <input type="checkbox" id="31" name="img1_1" style="position:absolute; top:35px; left:35px;" {{$rayon->img1_1 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="32" name="img1_2" style="position:absolute; top:40px; left:70px;" {{$rayon->img1_2 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="33" name="img1_3" style="position:absolute; top:40px; left:100px;" {{$rayon->img1_3 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="34" name="img1_4" style="position:absolute; top:60px; left:35px;" {{$rayon->img1_4 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="35" name="img1_5" style="position:absolute; top:60px; left:70px;" {{$rayon->img1_5 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="36" name="img1_6" style="position:absolute; top:60px; left:100px;" {{$rayon->img1_6 == 1 ? 'checked': ''}}   value="1" >
                        <!-- imagen tracera 1 -->
                        <input type="checkbox" id="37" name="img1_7" style="position:absolute; top:35px; left:165px;" {{$rayon->img1_7 == 1 ? 'checked': ''}}  value="1">
                        <input type="checkbox" id="38" name="img1_8" style="position:absolute; top:35px; left:200px;" {{$rayon->img1_8 == 1 ? 'checked': ''}}  value="1">
                        <input type="checkbox" id="39" name="img1_9" style="position:absolute; top:37px; left:230px;" {{$rayon->img1_9 == 1 ? 'checked': ''}}  value="1">
                        <input type="checkbox" id="40" name="img1_10" style="position:absolute; top:65px; left:160px;" {{$rayon->img1_10 == 1 ? 'checked': ''}}  value="1">
                        <input type="checkbox" id="41" name="img1_11" style="position:absolute; top:65px; left:200px;" {{$rayon->img1_11 == 1 ? 'checked': ''}}  value="1">
                        <input type="checkbox" id="42" name="img1_12" style="position:absolute; top:65px; left:235px;" {{$rayon->img1_12 == 1 ? 'checked': ''}}  value="1">
                        
                        
                        <img src="/img/imagen1.png" width="250">
                    </div>
                                        
                    <div class="col-sm-3">
                        <!-- imagen costado 1 -->
                        <input type="checkbox" id="43" name="img2_1" style="position:absolute; top:25px; left:45px;"  {{$rayon->img2_1 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="44" name="img2_2" style="position:absolute; top:40px; left:30px;"  {{$rayon->img2_2 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="45" name="img2_3" style="position:absolute; top:40px; left:100px;" {{$rayon->img2_3 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="46" name="img2_4" style="position:absolute; top:40px; left:150px;" {{$rayon->img2_4 == 1 ? 'checked': ''}}   value="1" >
                        <input type="checkbox" id="47" name="img2_5" style="position:absolute; top:25px; left:200px;" {{$rayon->img2_5 == 1 ? 'checked': ''}}  value="1" >
                        <input type="checkbox" id="48" name="img2_6" style="position:absolute; top:45px; left:240px;" {{$rayon->img2_6 == 1 ? 'checked': ''}}  value="1" >    
                        <img src="/img/imagen2.png" width="250">
                    </div>
                    <div class="col-sm-3">
                        <!-- imagen costado 2 -->
                        <input type="checkbox" id="49" name="img3_1" style="position:absolute; top:50px; left:30px;" {{$rayon->img3_1 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="50" name="img3_2" style="position:absolute; top:32px; left:55px;" {{$rayon->img3_2 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="51" name="img3_3" style="position:absolute; top:40px; left:120px;"{{$rayon->img3_3 == 1 ? 'checked': ''}}  value="1" >
                        <input type="checkbox" id="52" name="img3_4" style="position:absolute; top:40px; left:170px;"{{$rayon->img3_4 == 1 ? 'checked': ''}}  value="1" >
                        <input type="checkbox" id="53" name="img3_5" style="position:absolute; top:25px; left:220px;"{{$rayon->img3_5 == 1 ? 'checked': ''}}  value="1" >
                        <input type="checkbox" id="54" name="img3_6" style="position:absolute; top:45px; left:240px;"{{$rayon->img3_6 == 1 ? 'checked': ''}}  value="1" >    
                        <img src="/img/imagen3.png" width="250">
                    </div>
                    <div class="col-sm-3">
                        <!-- imagen arriba 1 -->
                        <input type="checkbox" id="55" name="img4_1" style="position:absolute; top:12px; left:35px;" {{$rayon->img4_1 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="56" name="img4_2" style="position:absolute; top:43px; left:35px;" {{$rayon->img4_2 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="57" name="img4_3" style="position:absolute; top:83px; left:35px;" {{$rayon->img4_3 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="58" name="img4_4" style="position:absolute; top:45px; left:60px;" {{$rayon->img4_4 == 1 ? 'checked': ''}} value="1" >
                        <input type="checkbox" id="59" name="img4_5" style="position:absolute; top:45px; left:120px;"{{$rayon->img4_5 == 1 ? 'checked': ''}}  value="1" >
                        <input type="checkbox" id="60" name="img4_6" style="position:absolute; top:45px; left:170px;"{{$rayon->img4_6 == 1 ? 'checked': ''}}  value="1" >
                        <img src="/img/imagen4.png" width="250">
                    </div>


                    
                </div>
                
                <div class="col-sm-12">
                    {!! Form::label("descripcion","Observaciones:") !!}<br>
                    {!! Form::textarea( "descripcion", $rayon->descripcion , ['class' => 'form-control' , 'placeholder' => 'Observaciones', 'rows'=> '5','id'=>'descripcion' ]) !!}
                </div>
                @endforeach   
                
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
        {!! Form::close() !!}
        <div class="text-right m-t-15">
                <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ordenes_de_trabajo/editcreate2/'.$orden->id.'') }}">Regresar</a>
                {!! Form::input('submit', 'submit', 'Siguiente', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonOrdenDeTrabajo3']) !!}
            </div>
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/js/ordenes_de_trabajo/editcreate3.js') !!}

@endsection