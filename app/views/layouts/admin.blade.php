<!DOCTYPE html>
    <!--[if lt IE 10 ]> <html class="badIE"> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>
            Fitness Force 2.1
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
        <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
    </head>

    <body>
    <div id="background">
        <img id="background-img" class="bg" src="../assets/img/site/bg/bg-01.jpg">
    </div>

        <!-- Container -->
        <div class="main-container">

        <div class="headbar">
            <span id="pageTitle">{{$title}}

        <li class="dropdown pull-right headProfile">
        {{HTML::image(Auth::user()->pic, Auth::user()->first_name, array("id" => "navProfileImage")) }}
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->first_name}} {{Auth::user()->last_name}} <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="editprofile"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>
            <li class="divider"></li>
            <li><a href="{{ URL::to('logout')}}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </li>
        </span>

        </div>
        <!-- Navbar -->
            <div class="navContainer" >
                <ul class="navCustom" id="navSide">
                    <li class=""><a href="#top"><span class="glyphicon glyphicon-chevron-up"></span>Top</a></li>
                    <h5 id="sideHeader">NAVIGATION</h5>
                    <li class="{{ Request::is( 'blog') ? 'active' : '' }}"><a href="#"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                    <li class="{{ Request::is( 'log') ? 'active' : '' }}"><a class="disabled" href="#"><span class="glyphicon glyphicon-lock"></span>Log</a></li>
                    <li class="{{ Request::is( 'blog') ? 'active' : '' }}"><a class="disabled" href="#"><span class="glyphicon glyphicon-lock"></span>Read</a></li>
                    <li class="{{ Request::is( 'dashboard') ? 'active' : '' }}"><a href="{{ URL::to('dashboard') }}"><span class="glyphicon glyphicon-dashboard"></span><span id="badge-data" class="badge pull-right hidden"></span>Dashboard</a></li>
                    <li class="{{ Request::is( 'user/*') ? 'active' : '' }}"><a href="user/{{Auth::user()->id}}"><span class="glyphicon glyphicon-user"></span>Me</a></li>
                    <li class="{{ Request::is( 'goal') ? 'active' : '' }}"><a class="disabled" href="#"><span class="glyphicon glyphicon-lock"></span>Acheive</a></li>
                    @if($isAdmin)
                    <li class="{{ Request::is( 'admin') ? 'active' : '' }}"><a class="" href="{{ URL::to('admin') }}"><span class="glyphicon glyphicon-tower"></span>Admin</a></li>
                    @endif
                </ul>

        </div>
        <!-- End of Nav -->



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


    </body>
</html>