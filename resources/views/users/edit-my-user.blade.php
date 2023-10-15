<div class="modal fade" id="userUpdateModal" tabindex="-1" role="dialog" aria-labelledby="userUpdateLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closePassword" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userUpdateLabel">Cambiar contraseña </h4>
            </div>
            <form id="{{ Auth::user()->id }}" class="update-user form-horizontal" role="form" method="POST" action="{{ url('/admin/user/store') }}">
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Contraseña Anterior</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="old-password">

                            <span id="old-password-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('old_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Contraseña</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="new-password">

                            <span id="new-password-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('new_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('new_password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('old_verify') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Verificar Nueva Contraseña</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="old-verify">

                            <span id="old-verify-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('old_verify'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old_verify') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="password-changed" class="alert alert-success alert-dismissible fade in hidden" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <p>La contraseña ha sido cambiada</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closePassword2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success">
                        <i class="fa fa-btn fa-unlock-alt"></i>Cambiar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>