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
        

        {{ HTML::style('assets/css/styles.css') }}
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
    @if (Auth::check()==true)
        <div class="headbar">
            <div id="pageTitle">{{$title}}

        <li class="dropdown pull-right headProfile">
        {{HTML::image(Auth::user()->pic, Auth::user()->userFirst, array("id" => "navProfileImage")) }}
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->userFirst}} {{Auth::user()->userLast}} <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="editprofile">Edit Profile</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
        </div>

        </div>
        <!-- Navbar -->
            <div class="navContainer" >
                <ul class="navCustom" id="navSide">
                    <li class=""><a href="#top"><span class="glyphicon glyphicon-chevron-up"></span>Top</a></li>
                    <h5 id="sideHeader">NAVIGATION</h5>
                    <li id="profileLink" style="display: none;">
                        <a class="navProfileLink" id="left-menu" href="#left-menu">{{HTML::image(Auth::user()->pic, Auth::user()->userFirst, array("id" => "navProfileImage")) }}</a>                    
                        <div class="userProgress">
                            <input type="text" value="0" rel="55" class="dial">
                        </div>
                        <h5 class="linkText">{{ Auth::user()->userFirst; }}</h5>
                    </li>
                    <li class="{{ Request::is( 'blog') ? 'active' : '' }}"><a href="{{ URL::to('blog') }}"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                    <li class="{{ Request::is( 'log') ? 'active' : '' }}"><a href="{{ URL::to('log') }}"><span class="glyphicon glyphicon-pencil"></span>Log</a></li>
                    <li class="{{ Request::is( 'blog') ? 'active' : '' }}"><a href="{{ URL::to('blog') }}"><span class="glyphicon glyphicon-book"></span><span id="badge-data" class="badge pull-right">3</span>Read</a></li>
                    <li class="{{ Request::is( 'dashboard') ? 'active' : '' }}"><a href="{{ URL::to('dashboard') }}"><span class="glyphicon glyphicon-dashboard"></span><span id="badge-data" class="badge pull-right">1</span>Dashboard</a></li>
                    <li class="{{ Request::is( 'user/*') ? 'active' : '' }}"><a href="user/{{Auth::user()->id}}"><span class="glyphicon glyphicon-user"></span>Me</a></li>
                    <li class="{{ Request::is( 'goal') ? 'active' : '' }}"><a href="{{ URL::to('goals') }}"><span class="glyphicon glyphicon-flag"></span>Acheive</a></li>
                </ul>

        <!-- Team -->
        <ul class="navCustom" id="navTeam">
                <h5 id="sideHeader">Team: {{ team::find(Auth::user()->teamNum)->teamName; }}</h5>
                @foreach ($teamMembers as $member)
                @if ($member->id != Auth::user()->id)
                <li class="userInfo" id="{{$member->id}}"><a class="navProfileLink" role="button" data-toggle="modal" href="#statDetailsModal">{{HTML::image($member->pic, $member->userfirst, array("id" => "navProfileImage")) }}

                    {{$member->userfirst}}  {{ $member->userlast}}</a>
                    <span id="team-progress" class="pull-left">
                        <div class="bar progress-low" id = "team-reward" style="width: {{ percentageRound(500000, $member->userTotalHrs); }}%">{{ percentageRound(500000, $member->userTotalHrs); }}%</div>
                    </span>
                </li>
                @endif
                @endforeach
            </ul>       
        </div>
        <!-- End of Nav -->


    @endif

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
        <script type="text/javascript" src="assets/js/slider-pips/jquery-ui-slider-pips.js"></script>


    </body>
</html>