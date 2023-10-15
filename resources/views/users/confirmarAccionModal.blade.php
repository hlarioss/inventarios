<!-- Modal -->
<div class="modal fade" id="modalConfirmarAccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form method="POST" id="ConfirmarAccionForm">
        {{--{{ method_field('put') }}--}}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Confirme sus credenciales</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('password_actual') ? 'has-error': '' }}">
                        <label for="password_actual">Contraseña:</label>
                        <input name="password_actual" class="form-control" type="password" placeholder="Ingresa contraseña">
                    </div>
                </div>

              <input type="hidden" name="_token" id="tokenConfirmarAccion" value="{{ csrf_token() }}">
              <input type="text" name="id" id="idConfirmacion">
              <input type="text" name="id2" id="idConfirmacion2">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btnConfirmarAccion" >Borrar</button>
            </div>
          </div>
        </div>
    </form>
</div>

@push('scripts')
   <script>

    if(window.location.hash === '#confirmar')
    {
        $('#modalConfirmarAccion').modal('show');
    }

    $('#modalConfirmarAccion').on('hide.bs.modal', function(){
        window.location.hash = '#';
        $("label.error").remove();
        BorrarFormularioConfirmar();

    });

    $('#modalConfirmarAccion').on('shown.bs.modal', function(){
        window.location.hash = '#confirmar';

    });
       
       
    var validator = $("#ConfirmarAccionForm").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            password_actual: {
                required: true
            }

        },
        messages: {
            password_actual: {
                required: "Por favor, ingrese contraseña"
            }
        }
    });

    $('#modalConfirmarAccion').on('shown.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        console.log('hola ',id);
        var modal = $(this);
        modal.find(".modal-body input[name='id']").val(id);

    });

    function BorrarFormularioConfirmar() {
        $("#ConfirmarAccionForm :input").each(function () {
            $(this).val('');
        });
    };


    </script>
@endpush