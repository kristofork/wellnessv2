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

        <!-- Container -->
        <div class="main-container">
    @if (Auth::check()==true)
        <div class="headbar">
            <span id="pageTitle">{{$title}}</span>

        <li class="dropdown pull-right headProfile">
        {{HTML::image(Auth::user()->pic, Auth::user()->first_name, array("id" => "navProfileImage")) }}
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->first_name}} {{Auth::user()->last_name}} <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="/editprofile"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>
            <li class="divider"></li>
            <li><a href="{{ URL::to('logout')}}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </li>
        

        </div>
        <!-- Navbar -->
            <div class="navContainer" >
                <ul class="navCustom" id="navSide">
                    <li class=""><a href="#top"><span class="glyphicon glyphicon-chevron-up"></span>Top</a></li>
                    <h5 id="sideHeader">NAVIGATION</h5>
                    <li class="{{ Request::is( 'blog') ? 'active' : '' }}"><a class="disabled" href="#"><span class="glyphicon glyphicon-lock"></span><span class="hidden-xs" id="nav-text">Read</span></a></li>
                    <li class="{{ Request::is( 'dashboard') ? 'active' : '' }}"><a href="{{ URL::to('dashboard') }}"><span class="glyphicon glyphicon-dashboard"></span><span id="badge-data" class="badge pull-right hidden"></span><span class="hidden-xs" id="nav-text">Dashboard</span></a></li>
                    <li class="{{ Request::is( 'user/*') || Request::is('editprofile') ? 'active' : '' }}"><a href="user/{{Auth::user()->id}}"><span class="glyphicon glyphicon-user"></span><span class="hidden-xs" id="nav-text">Me</span></a></li>
                    <li class="{{ Request::is( 'goal') ? 'active' : '' }}"><a class="disabled" href="#"><span class="glyphicon glyphicon-lock"></span><span class="hidden-xs" id="nav-text">Acheive</span></a></li>
                    @if($isAdmin)
                    <li class="{{ Request::is( 'admin') ? 'active' : '' }}"><a class="" href="{{ URL::to('admin') }}"><span class="glyphicon glyphicon-tower"></span><span class="hidden-xs" id="nav-text">Admin</span></a></li>
                    @endif
                </ul>
            <!-- If user is on a team -->    
            @if($teamname != "Individuals")
                <!-- Team -->
                <ul class="navCustom hidden-xs" id="navTeam">
                    <h5 id="sideHeader">Team: {{ $teamname}}</h5>
                    @foreach ($userYearStats as $userYearStat)
                    @if ($userYearStat->id != Auth::user()->id)
                    <li class="userInfo" id="{{$userYearStat->id}}"><a class="navProfileLink" role="button" data-toggle="modal" href="#statDetailsModal">{{HTML::image($userYearStat->pic, $userYearStat->first_name, array("id" => "navProfileImage")) }}

                        {{$userYearStat->first_name}}  {{ $userYearStat->last_name}}</a>
                        <span id="team-progress" class="pull-left">
                            <div class="bar progress-high" id = "team-reward" style="width: {{ percentageRound(500000, $userYearStat->time); }}%">{{ percentageRound(500000, $userYearStat->time); }}%</div>
                        </span>
                    </li>
                    @endif
                    @endforeach
                </ul>   
            @endif    
        </div>
        <!-- End of Nav -->


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
        {{ HTML::script('assets/js/main.js')}}
        @if($title = "Dashboard" || $title = "Profile")
        <script src="{{ asset('js/activities/new_activityCheck.js') }}"></script>
        @endif
        <script type="text/javascript" src="{{asset('assets/js/slider-pips/jquery-ui-slider-pips.js')}}"></script>

    </body>
</html>