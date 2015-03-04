<?php $current_user = Auth::user(); ?>
<!DOCTYPE html>
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<!--[if IE 8 | IE 9]>
  <script type="text/javascript">
    window.location = "/error";
  </script>
<![endif]-->
<!--[if IE 7]>
  <meta http-equiv="REFRESH" content="0;url=/error">
<![endif]-->

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
        {{ HTML::script('js/jquery/jquery-1.9.1.min.js') }}
        <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!-->
        {{ HTML::script('js/jquery/jquery-2.0.2.min.js') }}
    <!--<![endif]-->

    <!-- CSS are placed here -->

    {{ HTML::style('css/style.min.css') }}
    

</head>

<body>
       <div id="background"></div>
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
    {{ HTML::script('js/all-vendor.js')}}
    {{ HTML::script('js/app.min.js')}}
    {{ HTML::script('js/main.min.js')}}
    @if($title == "Dashboard")
    <script>
    initDash();
    </script>
    @elseif($title == "Profile")
    {{ HTML::script('js/vendor/d3.min.js') }}
    <script>
    initProfile();
    </script>
    @elseif($title == "Edit Profile")
    {{ HTML::script('js/upload/spin.min.js')}}
    {{ HTML::script('js/upload/jquery.ui.widget.js')}}
    {{ HTML::script('js/upload/jquery.iframe-transport.js')}}
    {{ HTML::script('js/upload/jquery.fileupload.min.js')}}
    {{ HTML::script('js/upload/jquery.fileupload-process.js')}}
    {{ HTML::script('js/upload/jquery.fileupload-validate.js')}}
    {{ HTML::script('js/upload/upload.min.js') }}
    <script>
    initEditProfile();
    </script>
    @elseif($title == "Log")
    <script>
    initLog();
    </script>
    @elseif($title == "Badges")
    <script>
    initBadge();
    </script>
    @else
    {{ HTML::script('js/blog.min.js') }}
    <script>
    initBlog();
    </script>
    @endif


</body>

</html>
