@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'OrdenDeTrabajoFormGolpe') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Golpes y Abollones</h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
			<input name="orden_id" id="orden_id" class="hide" type="text" value="{{$orden_de_trabajo->id}}">
            </div>
            <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <!-- imagen frente 1 -->
                        <input type="checkbox" name="img1_1" style="position:absolute; top:35px; left:35px;" value="1" >
                        <input type="checkbox" name="img1_2" style="position:absolute; top:40px; left:70px;" value="1" >
                        <input type="checkbox" name="img1_3" style="position:absolute; top:40px; left:100px;" value="1" >
                        <input type="checkbox" name="img1_4" style="position:absolute; top:60px; left:35px;" value="1" >
                        <input type="checkbox" name="img1_5" style="position:absolute; top:60px; left:70px;" value="1" >
                        <input type="checkbox" name="img1_6" style="position:absolute; top:60px; left:100px;" value="1" >
                        <!-- imagen tracera 1 -->
                        <input type="checkbox" name="img1_7" style="position:absolute; top:35px; left:165px;" value="1">
                        <input type="checkbox" name="img1_8" style="position:absolute; top:35px; left:200px;" value="1">
                        <input type="checkbox" name="img1_9" style="position:absolute; top:37px; left:230px;" value="1">
                        <input type="checkbox" name="img1_10" style="position:absolute; top:65px; left:160px;" value="1">
                        <input type="checkbox" name="img1_11" style="position:absolute; top:65px; left:200px;" value="1">
                        <input type="checkbox" name="img1_12" style="position:absolute; top:65px; left:235px;" value="1">
                        
                        
                        <img src="/img/imagen1.png" width="250">
                    </div>
                                        
                    <div class="col-sm-3">
                        <!-- imagen costado 1 -->
                        <input type="checkbox" name="img2_1" style="position:absolute; top:25px; left:45px;" value="1" >
                        <input type="checkbox" name="img2_2" style="position:absolute; top:40px; left:30px;" value="1" >
                        <input type="checkbox" name="img2_3" style="position:absolute; top:40px; left:100px;" value="1" >
                        <input type="checkbox" name="img2_4" style="position:absolute; top:40px; left:150px;" value="1" >
                        <input type="checkbox" name="img2_5" style="position:absolute; top:25px; left:200px;" value="1" >
                        <input type="checkbox" name="img2_6" style="position:absolute; top:45px; left:240px;" value="1" >    
                        <img src="/img/imagen2.png" width="250">
                    </div>
                    <div class="col-sm-3">
                        <!-- imagen costado 2 -->
                        <input type="checkbox" name="img3_1" style="position:absolute; top:50px; left:30px;" value="1" >
                        <input type="checkbox" name="img3_2" style="position:absolute; top:32px; left:55px;" value="1" >
                        <input type="checkbox" name="img3_3" style="position:absolute; top:40px; left:120px;" value="1" >
                        <input type="checkbox" name="img3_4" style="position:absolute; top:40px; left:170px;" value="1" >
                        <input type="checkbox" name="img3_5" style="position:absolute; top:25px; left:220px;" value="1" >
                        <input type="checkbox" name="img3_6" style="position:absolute; top:45px; left:240px;" value="1" >    
                        <img src="/img/imagen3.png" width="250">
                    </div>
                    <div class="col-sm-3">
                        <!-- imagen arriba 1 -->
                        <input type="checkbox" name="img4_1" style="position:absolute; top:12px; left:35px;" value="1" >
                        <input type="checkbox" name="img4_2" style="position:absolute; top:43px; left:35px;" value="1" >
                        <input type="checkbox" name="img4_3" style="position:absolute; top:83px; left:35px;" value="1" >
                        <input type="checkbox" name="img4_4" style="position:absolute; top:45px; left:60px;" value="1" >
                        <input type="checkbox" name="img4_5" style="position:absolute; top:45px; left:120px;" value="1" >
                        <input type="checkbox" name="img4_6" style="position:absolute; top:45px; left:170px;" value="1" >
                        <img src="/img/imagen4.png" width="250">
                    </div>

 
                </div>
        <br>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		{!! Form::close() !!}
        <br>
        {!! Form::open( array( 'id' => 'OrdenDeTrabajoFormRayon') ) !!}
        
        <div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Raspones</h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
			<input name="orden_id" id="orden_id" class="hide" type="text" value="{{$orden_de_trabajo->id}}">
            </div>
            <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <!-- imagen frente 1 -->
                        <input type="checkbox" name="img1_1" style="position:absolute; top:35px; left:35px;" value="1" >
                        <input type="checkbox" name="img1_2" style="position:absolute; top:40px; left:70px;" value="1" >
                        <input type="checkbox" name="img1_3" style="position:absolute; top:40px; left:100px;" value="1" >
                        <input type="checkbox" name="img1_4" style="position:absolute; top:60px; left:35px;" value="1" >
                        <input type="checkbox" name="img1_5" style="position:absolute; top:60px; left:70px;" value="1" >
                        <input type="checkbox" name="img1_6" style="position:absolute; top:60px; left:100px;" value="1" >
                        <!-- imagen tracera 1 -->
                        <input type="checkbox" name="img1_7" style="position:absolute; top:35px; left:165px;" value="1">
                        <input type="checkbox" name="img1_8" style="position:absolute; top:35px; left:200px;" value="1">
                        <input type="checkbox" name="img1_9" style="position:absolute; top:37px; left:230px;" value="1">
                        <input type="checkbox" name="img1_10" style="position:absolute; top:65px; left:160px;" value="1">
                        <input type="checkbox" name="img1_11" style="position:absolute; top:65px; left:200px;" value="1">
                        <input type="checkbox" name="img1_12" style="position:absolute; top:65px; left:235px;" value="1">
                        
                        
                        <img src="/img/imagen1.png" width="250">
                    </div>
                                        
                    <div class="col-sm-3">
                        <!-- imagen costado 1 -->
                        <input type="checkbox" name="img2_1" style="position:absolute; top:25px; left:45px;" value="1" >
                        <input type="checkbox" name="img2_2" style="position:absolute; top:40px; left:30px;" value="1" >
                        <input type="checkbox" name="img2_3" style="position:absolute; top:40px; left:100px;" value="1" >
                        <input type="checkbox" name="img2_4" style="position:absolute; top:40px; left:150px;" value="1" >
                        <input type="checkbox" name="img2_5" style="position:absolute; top:25px; left:200px;" value="1" >
                        <input type="checkbox" name="img2_6" style="position:absolute; top:45px; left:240px;" value="1" >    
                        <img src="/img/imagen2.png" width="250">
                    </div>
                    <div class="col-sm-3">
                        <!-- imagen costado 2 -->
                        <input type="checkbox" name="img3_1" style="position:absolute; top:50px; left:30px;" value="1" >
                        <input type="checkbox" name="img3_2" style="position:absolute; top:32px; left:55px;" value="1" >
                        <input type="checkbox" name="img3_3" style="position:absolute; top:40px; left:120px;" value="1" >
                        <input type="checkbox" name="img3_4" style="position:absolute; top:40px; left:170px;" value="1" >
                        <input type="checkbox" name="img3_5" style="position:absolute; top:25px; left:220px;" value="1" >
                        <input type="checkbox" name="img3_6" style="position:absolute; top:45px; left:240px;" value="1" >    
                        <img src="/img/imagen3.png" width="250">
                    </div>
                    <div class="col-sm-3">
                        <!-- imagen arriba 1 -->
                        <input type="checkbox" name="img4_1" style="position:absolute; top:12px; left:35px;" value="1" >
                        <input type="checkbox" name="img4_2" style="position:absolute; top:43px; left:35px;" value="1" >
                        <input type="checkbox" name="img4_3" style="position:absolute; top:83px; left:35px;" value="1" >
                        <input type="checkbox" name="img4_4" style="position:absolute; top:45px; left:60px;" value="1" >
                        <input type="checkbox" name="img4_5" style="position:absolute; top:45px; left:120px;" value="1" >
                        <input type="checkbox" name="img4_6" style="position:absolute; top:45px; left:170px;" value="1" >
                        <img src="/img/imagen4.png" width="250">
                    </div>


                   
                </div>
            
                <div class="col-sm-12">
                        {!! Form::label("descripcion","Observaciones:") !!}<br>
                         {!! Form::textarea( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones', 'rows'=> '5' ]) !!}
                
                    </div>

			<div class="text-right m-t-15">
                    <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ordenes_de_trabajo/editcreate2/'.$orden_de_trabajo->id.'') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Siguiente', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonOrdenDeTrabajo3']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')

{!! HTML::script('/js/ordenes_de_trabajo/create3.js') !!}
@endsection