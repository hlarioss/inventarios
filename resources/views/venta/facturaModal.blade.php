<!-- Modal -->
<div class="modal fade" id="facturaModal" tabindex="-1" role="dialog" aria-labelledby="facturaModalLabel">
		{!! Form::open( array( 'id' => 'FacturaForm') ) !!}
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body"> 
          <div class="row">
            <div class="col-sm-12">
              <h3 class="tittle-custom"> Creación de Factura </h3>
              <line>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-4">
                {!! Form::label("serie_id","Serie:") !!}
                <input type="number" class="hide" id="venta_id" name="venta_id" value="" >
                <select class="selectpicker" id='serie_id' name="serie_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                  @foreach ($series as $serie)
                    @if($serie->documento_id == 1 && $serie->estado_id == 2)
                      <option value="{{$serie->id}}">{{ $serie->serie}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="col-sm-4 form-group ">
                {!! Form::label("numero","Numero:") !!}
                {!! Form::text( "numero" , null , ['class' => 'form-control' , 'placeholder' => 'Numero:','id'=>'numero_f' ]) !!}
                
              </div>		
              <div class="col-sm-4" >
                {!! Form::hidden("tipo_pago_id","Tipo de Pago:") !!}
                <input type="hidden" name="tipo_pago_id" id="tipo_pago_id">
              </div>
              <div class="col-sm-4">
                  {!! Form::label("total","Total:") !!}
                  {!! Form::text( "total" , null , ['class' => 'form-control' , 'placeholder' => 'Total', 'disabled' => true]) !!}
                </div>
            </div>
            <br>
            <div id='error_n' style="font-size:16px; font-weight:bold; color:green"> </div>
            <div class="row">
              <div class="col-sm-4">
                {!! Form::hidden("fecha","Fecha:") !!}
                {!! Form::hidden( "fecha", Carbon\Carbon::now(), ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id'=>'fecha']) !!}
              </div>
              <div class="row">			              
            </div>
            <br>
            </div>
            </div>
            <br>
            <div class="text-right m-t-15">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              {!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonFactura']) !!}
            </div>
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
          <br> 
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </div>


