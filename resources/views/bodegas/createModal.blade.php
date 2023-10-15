<!-- Modal -->
<div class="modal fade" id="modalBodega" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'BodegaForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Bodega</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="nombre">Nombre de Bodega:</label>
                  <input type="text" name="nombre" placeholder="Ingrese Nombre de Bodega" class="form-control">

                </div>
                <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="direccion">Dirección:</label>
                  <input type="text" name="direccion" placeholder="Ingrese Dirección" class="form-control">

                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenBodega" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonBodegaModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>