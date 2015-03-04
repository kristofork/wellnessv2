<?php $current_user = Auth::user(); ?>
<!DOCTYPE html>
<!--[if lt IE 10 ]> <html class="badIE"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        Fitness Force 2.1
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--[if lt IE 10]>
        {{ HTML::script('js/jquery/jquery-1.9.1.min.js') }}
        <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!-->
    {{ HTML::script('js/jquery/jquery-2.0.2.min.js') }}

    <!--<![endif]-->

    <!-- CSS are placed here -->

    {{ HTML::style('css/admin.min.css') }}
</head>

<body>
    <div id="background"></div>

    <!-- Container -->
    <div class="main-container">

        <div class="headbar">
            <span id="pageTitle">{{$title}}

                <li class="dropdown pull-right headProfile">
                    {{HTML::image(Auth::user()->pic, Auth::user()->first_name, array("id" => "navProfileImage")) }}
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->first_name}} {{Auth::user()->last_name}} <b class="caret"></b></a>
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
            </span>

        </div>
        <!-- Navbar -->
        <div class="navContainer">
            <ul class="navCustom" id="navSide">
                <li class="">
                    <a href="#top">
                        <span class="glyphicon glyphicon-chevron-up"></span>Top</a>
                </li>
                <h3 id="sideHeader">Reports</h3>
                <li class="">
                    <a href="" class="disabled">
                        <span class="glyphicon glyphicon-dashboard"></span>User: Login 30d +</a>
                </li>
                <li class="">
                    <a href="" class="disabled">
                        <span class="glyphicon glyphicon-user"></span>User: Reward</a>
                </li>
                <li class="">
                    <a class="disabled" href="#">
                        <span class="glyphicon glyphicon-lock"></span>User: No Time</a>
                </li>
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

    {{ HTML::script('js/all-vendor.js')}}


</body>

</html>
