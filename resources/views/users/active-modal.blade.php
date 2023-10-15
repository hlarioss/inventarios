<div class="modal fade always-on-top" id="userActiveModal" tabindex="-1" role="dialog" aria-labelledby="userActiveModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="activeRecord2" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userActiveModalLabel">Esta seguro usted de activar <span id="message"></span></h4>
            </div>
            <form  class="active-user2 form-horizontal" role="form" method="POST">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    <div class="well">
                        <p class="active-message-modal">Nosotros necesitamos confirmar sus permisos para activarlo: <span class="entity"></span>
                            <br>
                            <div class="variable"></div>
                        </p>
                    </div>
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('password_active') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_active" required>

                            <span id="password_active-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('password_active'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_active') }}</strong>
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
                    <button type="button" id="activeRecord" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success confirm-active" id="active1">
                        <i  class="fa fa-btn fa-user-times"></i>Activar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>