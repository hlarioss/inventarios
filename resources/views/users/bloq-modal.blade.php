<div class="modal fade always-on-top" id="userBloqModal" tabindex="-1" role="dialog" aria-labelledby="userBloqModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="bloqRecord2" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userBloqModalLabel">Esta seguro usted de bloquear <span id="message"></span></h4>
            </div>
            <form  class="bloq-user2 form-horizontal" role="form" method="POST">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    <div class="well">
                        <p class="bloq-message-modal">Nosotros necesitamos confirmar sus permisos para bloquearlo: <span class="entity"></span>
                            <br>
                            <div class="variable"></div>
                        </p>
                    </div>
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('password_bloq') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_bloq" required>

                            <span id="password_bloq-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('password_bloq'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_bloq') }}</strong>
                            </span>
                            @endif
                            <div>
                                <p>
                                   Ingrese su contraseña para confirmar su identidad
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="confirm-bloq" class="alert alert-success alert-dismissible fade in hidden" role="alert">
                        <button type="button"  class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <p>El registro ha sido bloqueado</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="bloqRecord" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success confirm-bloq" id="bloq">
                        <i  class="fa fa-btn fa-user-times"></i>Bloquear
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>