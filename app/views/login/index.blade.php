@extends('layouts.master')

@section('content')

                <div id="welcomeBox">
                    <h3>Welcome to Wellness</h3>
                    <p>Learn, earn, and live</p>
                    <p id="slogan">a healthier life</p>
                </div>
                
                {{ Form::open(array('login', 'POST')) }}
                    {{ Form::label('username', 'Username:') }}
                    {{ Form::text('username') }}
                    {{ Form::label('password', 'Password:') }}
                    {{ Form::password('password') }}
                    <br />
                    {{ Form::submit('Login') }}
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
    
@stop