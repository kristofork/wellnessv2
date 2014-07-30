@extends('layouts.master')

@section('content')
    <div class="row welcomeRow">
        <div class="col-md-offset-1 col-md-5 well well-small" id="home_recent_activity">
            <h2>Recent Activity</h2>
            <ul class="recentActivity">

            </ul>
        </div>
            <div class="col-md-3 col-md-offset-1">
                <div id="welcomeBox">
                    <h3>Welcome to Wellness</h3>
                    <p>Learn, earn, and live</p>
                    <p id="slogan">a healthier life!</p>
                </div>
                
                {{ Form::open(array('url'=>'login','action'=> 'POST', 'class' => 'well form-horizontal', 'role' => 'form')) }}
                    <div class="form-group">
                        {{ Form::label('username', 'Username:', array('class'=> 'col-md-3 control-label')) }}
                        <div class="col-md-9">
                        {{ Form::text('username', Input::old('username'), array('placeholder' => 'Your Username', 'id' => 'username', 'class'=> 'form-control')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('password', 'Password:', array('class' => 'col-md-3 control-label')) }}
                        <div class="col-md-9">
                            {{ Form::password('password', array('placeholder' => 'Your Password', 'id' => 'password', 'class'=> 'form-control')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
    	                    {{ Form::submit('Login', array('class' => 'btn btn-success', 'id'=> 'loginBtn')) }}
    	                    <!-- Spinner Start-->
    						<div id="escapingBallG">
    						<div id="escapingBall_1" class="escapingBallG">
    						</div>
    						</div>
                        </div>
						<!-- Spinner Stop-->
					</div>
                {{ Form::close() }}
                @if($errors->has())
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <ul>
                    {{ $errors->first('username', '<li>:message</li>') }}
                    {{ $errors->first('password', '<li>:message</li>') }}
                    </ul>
                </div>
                @elseif (!is_null(Session::get('status_error')))
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    @if (is_array(Session::get('status_error')))
                    <ul>
                    @foreach (Session::get('status_error') as $error)
			<li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    @else
                        {{ Session::get('status_error') }}
                    @endif
                </div>
                @endif
            </div>
    </div>
@stop
