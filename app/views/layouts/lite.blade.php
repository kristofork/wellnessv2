<?php $current_user = Auth::user(); ?>
<!DOCTYPE html>
<!--[if lt IE 10 ]> <html class="badIE"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html>
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
    {{ HTML::style('assets/css/nprogress.css')}}

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
                {{HTML::image($current_user->pic, $current_user->first_name, array("id" => "navProfileImage")) }}
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$current_user->first_name}} {{$current_user->last_name}} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li class="{{ Request::is( 'log') ? 'active' : '' }}">
                      <a href="{{ URL::to('log') }}">
                          <span class="glyphicon glyphicon-pencil"></span> Log
                      </a>
                  </li>
                   <li class="{{ Request::is( 'dashboard') ? 'active' : '' }}">
                       <a href="{{ URL::to('dashboard') }}">
                           <span class="glyphicon glyphicon-dashboard"></span> Dashboard
                       </a>
                   </li>
                   <li class="{{ Request::is( 'blog') ? 'active' : '' }}">
                       <a href="{{ URL::to('blog') }}">
                           <span class="glyphicon glyphicon-book"></span> Blog
                       </a>
                   </li>
                    <li class="{{ Request::is( 'showProfile') ? 'active' : '' }}">
                        <a href="/user/{{$current_user->id}}">
                            <span class="glyphicons glyphicons-person"></span> Profile</a>
                    </li>                   
                    <li class="{{ Request::is( 'editprofile') ? 'active' : '' }}">
                        <a href="/editprofile">
                            <span class="glyphicon glyphicon-edit"></span> Edit Profile</a>
                    </li>
                    <li class="{{ Request::is( 'badges') ? 'active' : '' }}">
                        <a href="/badges">
                            <span class="glyphicon glyphicon-certificate"></span> Badges</a>
                    </li>
                    @if($isAdmin)
                    <li class="{{ Request::is( 'admin') ? 'active' : '' }}">
                        <a class="" href="{{ URL::to('admin') }}">
                            <span class="glyphicon glyphicon-tower"></span> Admin</a>
                    </li>
                    @endif                    
                    <li class="divider"></li>
                    <li>
                        <a href="{{ URL::to('logout')}}">
                            <span class="glyphicon glyphicon-log-out"></span> Logout</a>
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
    {{ HTML::script('assets/js/nprogress.js') }}
    {{ HTML::script('assets/js/main.js')}} 
    @if($title = "Dashboard" || $title = "Profile")
        <script src="{{ asset('js/activities/new_activityCheck.js') }}"></script>
        <script>initHoverCard();</script>
        {{ HTML::script('js/activities/pagination.js') }}
    @endif
    @if($title = "Blog")
    {{ HTML::script('assets/js/blog.js') }}
    @endif
    @if($title = "Profile")
    {{ HTML::script('assets/js/form/calendar.js')}} 
    @endif
    <script type="text/javascript" src="{{asset('assets/js/slider-pips/jquery-ui-slider-pips.js')}}"></script>

    {{ HTML::script('assets/js/retina.min.js')}}
    {{ HTML::script('assets/js/modernizr.js')}}
    

</body>

</html>
