<div class="modal fade always-on-top" id="userDeleteModal2" tabindex="-1" role="dialog" aria-labelledby="userDeleteModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="deleteRecord2" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userDeleteModalLabel">Esta seguro de ejecutar el corte de caja <span id="message"></span></h4>
            </div>
            <form id="{{ Auth::user()->id }}" class="delete-user form-horizontal" role="form" method="POST">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    <div class="well">
                        <p class="delete-message-modal">Nosotros necesitamos confirmar sus permisos para realizar el corte de caja: <span class="entity"></span>
                            <br>
                            <div class="variable"></div>
                        </p>
                    </div>
                    <div class="form-group{{ $errors->has('password_delete2') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_delete2" required>
                            <span id="password_delete-error2">
                                <strong></strong>
                            </span>
                            <div>
                                <p>
                                 Ingrese su contraseña para confirmar su identidad
                             </p>
                         </div>
                     </div>
                 </div>
                 <div id="confirm-delete" class="alert alert-success alert-dismissible fade in hidden" role="alert">
                    <button type="button"  class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <p>El registro ha sido borrado</p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="deleteRecord3" class="btn btn-default" data-dismiss="modal">Cancelar
                </button>
                <button class="btn btn-success confirm-delete2" id="delete2">
                    <i class="fa fa-btn fa-user-times"></i>Ejecutar Corte
                </button>
            </div>
        </form>
    </div>
</div>
</div>