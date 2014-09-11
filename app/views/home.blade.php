<!DOCTYPE html>
    <!--[if lt IE 10 ]> <html class="badIE"> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>
            @section('title')
            Fitness Force 2.1
            @show
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--[if lt IE 10]>
        {{ HTML::script('assets/js/jquery-1.9.1.min.js') }}
        <![endif]-->
        <!--[if (gt IE 9)|!(IE)]><!-->
            {{ HTML::script('assets/js/jquery-2.0.2.js') }}

        <!--<![endif]-->
        
        <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
        <!-- CSS are placed here -->
        {{ HTML::style('assets/css/bootstrap.css') }}
        

        {{ HTML::style('assets/css/less/style.css') }}
        {{ HTML::style('assets/css/spinner.css') }}
        {{ HTML::style('assets/css/jquery.sidr.dark.css') }}
        {{ HTML::style('assets/css/jquery-ui-slider-pips.css') }}
        <link href='http://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400,600' rel='stylesheet' type='text/css'>
    </head>

    <body>
    <div id="background">
        <img id="background-img" class="bg" src="../assets/img/site/bg/bg-01.jpg">
    </div>

            <!-- if browser does not meet the minimum req -->
                <div class="modal hide fade" id="browser">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Bad IE</h3>
                </div>
                <div class="modal-body">
                <p>Sorry! Internet Explorer 9 and below are not supported. Please upgrade your browser or use one of the supported browsers listed below. Sorry for any inconvenience!</p>
                </div>
                <div class="modal-footer">
                    {{ HTML::image_link("https://www.google.com/intl/en/chrome/browser/" , 'assets/img/site/browsers/ch.gif', 'Chrome', array("class"=>"browser-icon", 'title'=> 'Chrome 4 or Higher', 'data-toggle' =>'tooltip')) }}
                    {{ HTML::image_link("http://www.mozilla.org/en-US/firefox/new/" , 'assets/img/site/browsers/ff.gif', 'FireFox', array("class"=>"browser-icon", 'title'=> 'FireFox 4 or Higher', 'data-toggle' =>'tooltip')) }}
                    {{ HTML::image_link("http://www.microsoft.com/en-us/download/internet-explorer-10-details.aspx" , 'assets/img/site/browsers/ie.gif', 'Internet Explorer', array("class"=>"browser-icon", 'title'=> 'IE 10 or Higher', 'data-toggle' =>'tooltip')) }}
                    {{ HTML::image_link("http://support.apple.com/kb/DL1531" , 'assets/img/site/browsers/sa.gif', 'Safari', array("class"=>"browser-icon", 'title'=> 'Safari 5 or Higher', 'data-toggle' =>'tooltip')) }}
                    {{ HTML::image_link("http://www.opera.com/" , 'assets/img/site/browsers/o.gif', 'Safari', array("class"=>"browser-icon", 'title'=> 'Opera 10.5 or Higher', 'data-toggle' =>'tooltip')) }}
                <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
                </div>

    <div class="cover-container">
            <div class="col-md-offset-1 col-md-5 well well-small" id="home_recent_activity">
                    <h2>Recent Activity</h2>
                    <ul class="recentActivity">
        
                    </ul>
                </div>
                <div class="col-md-3 col-md-offset-1">
                    <div id="welcomeBox">
                        <h3>Welcome to Wellness</h3>
                    </div>
                        
                        {{ Form::open(array('url'=>'login','action'=> 'POST', 'class' => 'well form-horizontal', 'id'=> 'login-form', 'role' => 'form')) }}
                            <div class="form-group">
                                
                                <div class="col-md-12">
                                    {{ Form::label('username', 'Username:', array('class'=> 'control-label')) }}
                                {{ Form::text('username', Input::old('username'), array('placeholder' => 'Your Username', 'id' => 'username', 'class'=> 'form-control')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    {{ Form::label('password', 'Password:', array('class' => 'control-label')) }}
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

        {{ HTML::script('assets/js/jquery-ui-1.10.3.min.js') }}
        {{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }}
        {{ HTML::script('assets/js/timeplugin.js')}}
        {{ HTML::script('assets/js/main.js')}}

    </body>
</html>
