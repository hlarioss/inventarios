<div class="modal fade" id="userUpdate2Modal" tabindex="-1" role="dialog" aria-labelledby="userUpdateLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeProfile" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userUpdateLabel">Update My Information  </h4>
            </div>
            <form class="update-userInfo form-horizontal" role="form" method="POST" action="{{ url('/admin/user/store') }}">
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('old_name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="old-name">

                            <span id="old-name-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('old_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('old_email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Email</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="old-email">

                            <span id="old-email-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('old_email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old_email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="password-changed2" class="alert alert-success alert-dismissible fade in hidden" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <p>The information has been updated</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeProfile2" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">
                        <i class="fa fa-btn fa-unlock-alt" id="editInformation"></i>Update Information </button>
                    </div>
                </form>
            </div>
        </div>
    </div>