<!DOCTYPE html>
<!--[if lt IE 10 ]> <html class="badIE"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        @if('title')
        @section('title') Wellness 2 @show
        @endif
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
    {{ HTML::style('assets/css/less/style-lite.css') }}
    {{ HTML::style('assets/css/spinner.css') }}
    {{ HTML::style('assets/css/jquery.sidr.dark.css') }}
    {{ HTML::style('assets/css/jquery-ui-slider-pips.css') }}
    {{ HTML::style('assets/css/glyphicons.css')}}

</head>

<body>
    <div id="background">
        <img id="background-img" class="bg" src="{{URL::asset('assets/img/site/bg/bg-01.jpg')}}">
    </div>

    <!-- Container -->
    <div class="main-container">
        @if (Auth::check()==true)
        <div class="headbar">
            <span id="pageTitle">{{$title}}</span>

            <li class="dropdown pull-right headProfile">
                {{HTML::image(Auth::user()->pic, Auth::user()->first_name, array("id" => "navProfileImage")) }}
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->first_name}} {{Auth::user()->last_name}} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/editprofile">
                            <span class="glyphicon glyphicon-edit"></span>Edit Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ URL::to('logout')}}">
                            <span class="glyphicon glyphicon-log-out"></span>Logout</a>
                    </li>
                </ul>
            </li>
        </div>
        @endif

        <!-- check for flash notification message -->
        @if(Session::has('flash_notice'))
            <div id="flash_notice">{{ Session::get('flash_notice') }}</div>
        @endif
        <!-- Content -->
        @yield('content')

    </div>

    <!-- Scripts are placed here -->

    {{ HTML::script('assets/js/jquery-ui-1.10.3.min.js') }} 
    {{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }} 
    {{ HTML::script('assets/js/timeplugin.js')}} 
    {{ HTML::script('assets/js/jquery.hoverIntent.minified.js')}} 
    {{ HTML::script('assets/js/main.js')}} 
    @if($title = "Dashboard" || $title = "Profile")
        <script src="{{ asset('js/activities/new_activityCheck.js') }}"></script>
    @endif
    <script type="text/javascript" src="{{asset('assets/js/slider-pips/jquery-ui-slider-pips.js')}}"></script>

    {{ HTML::script('assets/js/retina.min.js')}}
    {{ HTML::script('assets/js/modernizr.js')}}
    

</body>

</html>
