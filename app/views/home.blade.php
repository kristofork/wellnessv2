<!DOCTYPE html>
<!--[if lt IE 10 ]> <html class="badIE"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        @section('title') Wellness 2 @show
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
    {{ HTML::style('assets/css/bootstrap.css') }} {{ HTML::style('assets/css/less/cover-lite.css') }} {{ HTML::style('assets/css/spinner.css') }} {{ HTML::style('assets/css/jquery.sidr.dark.css') }} {{ HTML::style('assets/css/jquery-ui-slider-pips.css') }} {{ HTML::style('assets/css/jquery.FullPage.css') }}
    <link href='http://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400,600' rel='stylesheet' type='text/css'>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>

<body style="position:fixed; height: 100%; width: 100%;">
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
            {{ HTML::image_link("https://www.google.com/intl/en/chrome/browser/" , 'assets/img/site/browsers/ch.gif', 'Chrome', array("class"=>"browser-icon", 'title'=> 'Chrome 4 or Higher', 'data-toggle' =>'tooltip')) }} {{ HTML::image_link("http://www.mozilla.org/en-US/firefox/new/" , 'assets/img/site/browsers/ff.gif', 'FireFox', array("class"=>"browser-icon", 'title'=> 'FireFox 4 or Higher', 'data-toggle' =>'tooltip')) }} {{ HTML::image_link("http://www.microsoft.com/en-us/download/internet-explorer-10-details.aspx" , 'assets/img/site/browsers/ie.gif', 'Internet Explorer', array("class"=>"browser-icon", 'title'=> 'IE 10 or Higher', 'data-toggle' =>'tooltip')) }} {{ HTML::image_link("http://support.apple.com/kb/DL1531" , 'assets/img/site/browsers/sa.gif', 'Safari', array("class"=>"browser-icon", 'title'=> 'Safari 5 or Higher', 'data-toggle' =>'tooltip')) }} {{ HTML::image_link("http://www.opera.com/" , 'assets/img/site/browsers/o.gif', 'Safari', array("class"=>"browser-icon", 'title'=> 'Opera 10.5 or Higher', 'data-toggle' =>'tooltip')) }}
            <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
        </div>
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
                        <span id="iconTime" class="glyphicon glyphicon-time"><div id="glyph-text">20k</div></span>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <span id="iconUser" class="glyphicon glyphicon-user"><div id="glyph-text">50</div></span>
                        
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <span id="iconHeart" class="glyphicon glyphicon-heart"><div id="glyph-text">1k</div></span>
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

    {{ HTML::script('assets/js/jquery-ui-1.10.3.min.js') }} {{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }} {{ HTML::script('assets/js/timeplugin.js')}}
    {{ HTML::script('assets/js/jquery.easings.min.js' )}}
    {{ HTML::script('assets/js/jquery.slimscroll.min.js') }}
    {{ HTML::script('assets/js/jquery.fullPage.min.js') }}

    <script type="text/javascript">
        $(function () {
            $('ul.top-users').load('/topusers');
            $('ul.recentActivity').load('/activity-minifeed', function () {
                jQuery("abbr.timeago").timeago();

                // hide all quotes except the first
                $('ul.recentActivity li').hide().eq(0).show();

                var pause = 6000;
                var motion = 500;

                var quotes = $('ul.recentActivity li');
                var count = quotes.length;
                var i = 0;

                setTimeout(transition, pause);

                function transition() {
                    quotes.eq(i).slideUp(500);

                    if (++i >= count) {
                        i = 0;
                    }

                    quotes.eq(i).animate({
                        opacity: 'toggle',
                        top: '0px'
                    }, 500);

                    setTimeout(transition, pause);
                }


            });
        });
    </script>
    <script type="text/javascript">
		$(document).ready(function() {
			$('#fullpage').fullpage({
				sectionsColor: ['#fff', '#ccdcff', '#7BAABE', 'whitesmoke', '#ccddff'],
                resize: false,
                anchors:['home', 'login'],
                navigation: true,
                navigationTooltips: ['Welcome','Login']
			});
		});
    </script>
</body>

</html>
