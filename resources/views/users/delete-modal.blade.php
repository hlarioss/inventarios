<div class="modal fade always-on-top" id="userDeleteModal" tabindex="-1" role="dialog" aria-labelledby="userDeleteModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="deleteRecord2" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userDeleteModalLabel">Esta seguro usted de borrar <span id="message"></span></h4>
            </div>
            <form  class="delete-user2 form-horizontal" role="form" method="POST">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    <div class="well">
                        <p class="delete-message-modal">Nosotros necesitamos confirmar sus permisos para borrar: <span class="entity"></span>
                            <br>
                            <div class="variable"></div>
                        </p>
                    </div>
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('password_delete') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_delete" required>

                            <span id="password_delete-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('password_delete'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_delete') }}</strong>
                            </span>
                            @endif
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
                    <button type="button" id="deleteRecord" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success confirm-delete" id="delete">
                        <i  class="fa fa-btn fa-user-times"></i>Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>