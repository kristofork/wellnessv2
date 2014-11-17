                {{ Form::open(array('url'=>'login','action'=> 'POST', 'class' => 'well form-horizontal', 'id'=> 'login-form', 'role' => 'form')) }}
                <div class="form-group">
        
                    <div class="col-md-12">
                        {{ Form::label('username', 'Username:', array('class'=> 'control-label')) }} {{ Form::text('username', Input::old('username'), array('placeholder' => 'Your Username', 'id' => 'username', 'class'=> 'form-control')) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        {{ Form::label('password', 'Password:', array('class' => 'control-label')) }} {{ Form::password('password', array('placeholder' => 'Your Password', 'id' => 'password', 'class'=> 'form-control')) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9">
                        @if(Session::has('flash_notice'))
                        <span>{{Session::get('flash_notice')}}</span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        {{ Form::submit('Login', array('class' => 'btn btn-success', 'id'=> 'loginBtn')) }}
                    </div>
        
                </div>
                {{ Form::close() }}