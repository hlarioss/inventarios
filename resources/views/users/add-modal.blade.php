<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeCreateUser" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userModalLabel">Agregar Nuevo Usuario</h4>
            </div>
            <form id="add-new-user" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/store') }}">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Nombre</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                            <span id="name-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Rol</label>

                        <div class="col-md-6">
                            <select class="form-control" id='role' name="role" value="{{ old('role')}}">
                                @foreach ($rolesArrays as $rolesArray)
                                <option value="{{$rolesArray->id}}">{{ $rolesArray->name  }}</option>;
                                @endforeach
                            </select>
                            <span id="role-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('role'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Correo Electrónico</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}">

                            <span id="email-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Contraseña</label>

                        <div class="col-md-6">
                            <input type="password" id="password" class="form-control" name="password">

                            <span id="password-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Confirmar Contraseña</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">

                            <span id="password_confirmation-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="closeCreateUser2" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success">
                        <i class="fa fa-btn fa-user-plus"></i>Añadir Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>