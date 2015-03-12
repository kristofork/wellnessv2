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
    <title>Wellness v2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <!--[if lt IE 10]>
        {{ HTML::script('js/jquery/jquery-1.9.1.min.js') }}
        <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!-->
        {{ HTML::script('js/jquery/jquery-2.0.2.min.js') }}
    <!--<![endif]-->

    <!-- CSS are placed here -->
    {{ HTML::style('css/all-jquery.css') }}
    {{ HTML::style('css/all-vendor.min.css')}}
    {{ HTML::style('css/cover-lite.min.css') }}
    
</head>

<body style="position:fixed; height: 100%; width: 100%;">
    <div id="background">

    </div>

    <div id="fullpage" class="site-wrapper">
       
        <div class="cover-container section active">     
            <div class="row row-centered">
                <div class="col-md-6 col-centered">
                    <div class="welcomeBox">
                        <h1>Wellness</h1>
                    </div>
                </div>
            </div>
            <div class="row row-centered" id="company">
                <div class="col-md-3 col-centered">
                    <div class="welcomeBox">
                        <h4>by Urban Engineers</h4>
                    </div>
                </div>
            </div>
            <div class="col-xs-offset-4 col-xs-4 col-sm-offset-5 col-sm-2 col-md-offset-5 col-md-2">
                <div class="row row-centered welcomeIcon">
                    <div class="col-xs-4 col-sm-4 col-md-4 welcomeIconContainer">
                        <span id="iconTime" class="glyphicons glyphicons-stopwatch"><div id="glyph-text">{{NumberFormat($totalActivity)}}</div></span>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <span id="iconUser" class="glyphicons glyphicons-user"><div id="glyph-text">{{$totalUsers}}</div></span>
                        
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <span id="iconHeart" class="glyphicons glyphicons-heart"><div id="glyph-text">{{$totalLikes}}</div></span>
                    </div>                                        
                </div>
            </div>
        
            <div class="col-md-offset-1 col-md-5 well well-small hidden" id="home_recent_activity" style="overflow:hidden">
                <ul class="recentActivity"></ul>
            </div>
            <div class="col-md-offset-1 col-md-5 well well-small hidden" id="home_recent_activity" style="margin-top:-120px">
                <ul class="top-users"></ul>
            </div>
            
            <div id="iconLoginPosition" class="col-xs-offset-4 col-xs-4 col-sm-offset-5 col-sm-2 col-md-offset-5 col-md-2">
                <div class="col-md-12">
                   <div id="iconLogin">
                   <a href="#login">
                    <span class="glyphicon glyphicon-chevron-down">

                    </span></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="cover-container section" data-anchor="login">
            <div class="col-md-offset-4 col-md-4">
                @include('_partials/loginform')
            </div>
        </div>
    </div>
    
    {{ HTML::script('js/all-vendor.js' )}}
    {{ HTML::script('js/app.min.js') }}
<script>
    initFullPage();
    </script>
</body>

</html>
