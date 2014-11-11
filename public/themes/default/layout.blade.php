<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@yield('title')</title>
        <!--[if lt IE 10]>
        {{ HTML::script('assets/js/jquery-1.9.1.min.js') }}
        <![endif]-->
        <!--[if (gt IE 9)|!(IE)]><!-->
            {{ HTML::script('assets/js/jquery-2.0.2.js') }}
        <!--<![endif]-->
    <link href='//fonts.googleapis.com/css?family=OFL+Sorts+Mill+Goudy+TT' rel='stylesheet' type='text/css'/>
    {{ HTML::style('assets/css/bootstrap.css') }}
    {{ HTML::style('assets/css/bootstrap-responsive.css') }}
    <style>body {padding-top: 50px;}</style>
    <link href="{{ asset(theme_path('css/style.css')) }}" rel="stylesheet" media="screen">
        {{ HTML::style('assets/css/styles.css') }}
        {{ HTML::style('assets/css/spinner.css') }}
        {{ HTML::style('assets/css/jquery.sidr.dark.css') }}
        <link href='http://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <div id="background">
        <img id="background-img" class="bg" src="../assets/img/site/bg/bg-01.jpg">
    </div>
    <div class="container">
         @if (Auth::check()==true)
        <!-- Navbar -->
            <div class="navContainer" >
                <ul class="navCustom">
                <li class=""><a class="navProfileLink" href="#">{{HTML::image(Auth::user()->pic, Auth::user()->first_name, array("id" => "navProfileImage")) }}</a>                    
                    <div class="userProgress">
                        <input type="text" value="0" rel="55" class="dial">
                    </div>
                    <h5 class="linkText">{{ Auth::user()->first_name; }}</h5>
                </li>
                    <li class="{{ Request::is( 'blog') ? 'active' : '' }}"><a href="{{ URL::to('blog') }}"><img id="navImg" src="assets/img/site/newspaper.png"/></a><p>Read</p></li>
                    <li class="{{ Request::is( 'dashboard') ? 'active' : '' }}"><a href="{{ URL::to('dashboard') }}"><img id="navImg" src="assets/img/site/dashboard.png"/></a><p>Progress</p></li>
                    <li class="{{ Request::is( 'profile') ? 'active' : '' }}"><a href="{{ URL::to('user') }}"><img id="navImg" src="assets/img/site/id-card.png"/></a><p>Me</p></li>
                    <li class="{{ Request::is( 'goal') ? 'active' : '' }}"><a href="{{ URL::to('goals') }}"><img id="navImg" src="assets/img/site/test-tube.png"/></a><p>Acheive</p></li>
                </ul>
            </div> <!-- End of Nav -->
    @endif

      <div class="content">
        @yield('content')
      </div>
      <footer>

      </footer>
    </div>
    {{ HTML::script('assets/js/jquery.hoverIntent.minified.js')}}
    {{ HTML::script('assets/js/jquery.sidr.min.js')}}
    {{ HTML::script('assets/js/timeplugin.js')}}
    {{ HTML::script('assets/js/jquery.knob.js')}}
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    {{ HTML::script('assets/js/blog.js') }}
    {{ HTML::script('assets/js/main.js')}}

  </body>
</html>
