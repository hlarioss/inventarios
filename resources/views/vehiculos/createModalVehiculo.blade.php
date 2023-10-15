<!-- Modal -->
<div class="modal fade" id="ModalVehiculo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        {!! Form::open( array( 'id' => 'VehiculoForm') ) !!}
        
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Agrega</h4>
                </div>
                <div class="modal-body">
                        @include('vehiculos.formularioVehiculo')
                        <input type="hidden" name="_token" id="tokenVehiculo" value="{{ csrf_token() }}">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonVehiculoModal">Agregar</button>
                </div>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
