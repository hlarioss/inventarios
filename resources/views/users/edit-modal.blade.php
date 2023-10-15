<div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditUser" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Edit Usuario</h4>
            </div>
            <form id="edit-user-form" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/store') }}">
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
                            <!-- <input type="text" class="form-control" name="name" value="{{ old('name') }}"> -->
                            <select class="form-control" id='roleUser' name="roleUser" value="{{ old('role')}}">
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
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeEditUser2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" id="editClassButton">
                        <i  class="fa fa-btn fa-user"></i>Editar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>