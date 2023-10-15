<div class="modal fade always-on-top" id="userActiveModel" tabindex="-1" role="dialog" aria-labelledby="userActiveModelLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="deleteRecord2" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userActiveModelLabel">Esta seguro usted de activar esta entidad <span id="message"></span></h4>
            </div>
            <form class="delete-user1 form-horizontal" role="form" method="POST">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    <div class="well">
                        <p class="delete-message-modal">Nosotros necesitamos confirmar sus permisos para activar: <span class="entity"></span>
                            <br>
                            <div class="variable"></div>
                        </p>
                    </div>
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('password_delete_a') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_delete_a" required>

                            <span id="password_delete_a-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('password_delete_a'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_delete_a') }}</strong>
                            </span>
                            @endif
                            <div>
                                <p>
                                   Ingrese su contraseña para confirmar su identidad
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="confirm-active" class="alert alert-success alert-dismissible fade in hidden" role="alert">
                        <button type="button"  class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <p>El registro ha sido activado</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="activeRecord3" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success confirm-active" id="active">
                        <i  class="fa fa-btn fa-check"></i>Activar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>