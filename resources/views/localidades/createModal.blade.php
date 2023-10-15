<!-- Modal -->
<div class="modal fade" id="modalLocalidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'LocalidadForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Localidad</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="nombre">Nombre de Localidad:</label>
                  <input type="text" name="nombre" placeholder="Ingrese Nombre de Localidad" class="form-control">

                </div>
                <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="direccion">Dirección:</label>
                  <select class="form-control" name="bodega_id" id="bodega_id">
                    <option value="">Selecciona Bodega</option>
                      @foreach ($bodegas as $tipo)
                      <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                      @endforeach
                  </select>

                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenLocalidad" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonLocalidadModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>