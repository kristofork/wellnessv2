<form class="form-horizontal" action="{{ action('UserController@updatePassword') }}" method="POST">

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <input type="password" name="password" class="form-control" placeholder="New Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <input class="btn btn-primary btn-sm btn-block" type="submit" value="Reset Password">
        </div>
    </div>
    @if(Session::has('status'))
    <p>{{ Session::get('status') }}</p>
    @endif 
    @if(Session::has('error'))
        <p>{{ Session::get('error') }}</p>
    @endif
</form>
