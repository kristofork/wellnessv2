@extends('layouts.lite') 

@section('content')


    @if(Session::has('message'))
    <div id="dash-side-right" class="alert alert-custom">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <p>{{Session::get('message') }}</p>
    </div>
    @endif

    <div class="row-centered table-container" style="position:relative;">
    <div id="activity" class="col-centered masthead tablecell-container" style="height:250px;">
       <div class="tint">
           <div class="" id="stats_profile_image">
            <div id="img-container">
                <img class="img-circle" id="stats_profileImg" src='{{$pic}}'>
            </div>
           </div>
        <!-- Tab panes 
        <div class="tab-pane fluid-container " id="activity">
            <div class="row">
                <div class="col-xs-2 col-md-2 stats_data_container">
                    <div class="row">
                        <span>{{$time_week}}</span>
                        <h5>Current Week</h5>
                    </div>
                </div>
                <div class="col-xs-2 col-md-2 stats_data_container">
                    <div class="row">
                        <span>{{$time_lastweek}}</span>
                        <h5>Last Week</h5>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4" id="stats_profile">
                    <div class="row hidden" id="stats_profile_name">
                        <h5>{{$name['first_name']}} {{$name['last_name']}}</h5>
                    </div>
                    <div class="row" id="stats_profile_image">
                        <div id="img-container">
                            <img class="img-circle" id="stats_profileImg" src='{{$pic}}'>
                        </div>
                        <div class="hidden" id="stats-container">
                            <span id="label">{{ $user_title }}</span>
                            <span id="points">{{$user_points}}/{{$required_points}}</span>
                        </div>
                        <span class="hidden" id="stats-progress">
                            <div id="progress">
                                <div class="bar progress-high" id="team-reward" style="text-align:left;color:#000;width:{{ percentageRound($required_points,$user_points) }}%">{{ percentageRound($required_points,$user_points) }}%</div>
                            </div>
                        </span>
                    </div>
                    <div class="row hidden" id="stats_profile_date">
                        <h6>Active member since {{$year}}</h6>
                    </div>
                </div>
                <div class="col-xs-2 col-md-2 stats_data_container">
                    <div class="row">
                        <span>{{$user_rank}} of {{$user_count}}</span>
                        <h5>Rank</h5>
                    </div>
                </div>
                <div class="col-xs-2 col-md-2 stats_data_container">
                    <div class="row">
                        @if ($teamname != "Individuals")
                            <span>{{$team_rank}} of {{$team_count}}</span>
                        @else
                            <span>0 of 0</span>
                        @endif
                            <h5>Team Rank</h5>
                    </div>
                </div>
            </div>
        </div>
        -->
    </div> <!-- End of Tint -->
    </div>
</div>
   <div id="dashDataRow" class="">
        <div class="col-md-3 logDataCol">
            <span id="likeCount" class="glyphicons heart"></span>
            <div id="glyph-text">107</div>  
        </div> 
     <div class="col-md-3 logDataCol">
        <span id="rankCount" class="glyphicons stats"></span>
            <div id="glyph-text">1 of 200</div> 
     </div>

     <div class="col-md-3 logDataCol">
        <span id="timeCount" class="glyphicons stopwatch"></span>
        <div id="glyph-text">74 of 240</div> 
     </div>
     <div class="col-md-3 logDataCol">
        <span id="teamrankCount" class="glyphicons group"></span>
        <div id="glyph-text">7 of 24</div> 
     </div>
    </div>
    <!-- Start of Recent Activity (middle column) -->
    <div class="row-centered" style="position:relative;">
    <div class="col-centered col-md-8" id="recent_activity_container">
        <h3>Recent Activity</h3>
        {{ Form::open(array('url' => 'activity-filter', 'method' => 'GET', 'id' => 'activity-type-form')) }}
        <div class="btn-group pull-right activity-type" data-toggle="buttons">
            <label class="btn btn-default btn-xs">
                <input type="radio" name="filter" value="User">
                <span class="glyphicon glyphicon-user"></span>
            </label>
            <label class="btn btn-default btn-xs">
                <input type="radio" name="filter" value="Team">
                <span id="custom-glyph-user" style="font-size:8px" class="glyphicon glyphicon-user"></span>
                <span class="glyphicon glyphicon-user"></span>
            </label>
            <label class="btn btn-default btn-xs active">
                <input type="radio" name="filter" value="Everyone">
                <span class="glyphicon glyphicon-globe"></span>
            </label>
        </div>
        {{ Form::close() }}
        <ul class="recentActivity">
            @include('_partials.activityfeed')
        </ul>
    </div>
</div>

{{ HTML::script('assets/js/highcharts/highcharts.js')}} 
{{ HTML::script('assets/js/highcharts/modules/exporting.js')}} 
{{ HTML::script('assets/js/jquery.hoverIntent.minified.js')}} 
{{ HTML::script('assets/js/canvasjs.min.js')}} 
{{ HTML::script('assets/js/jquery.sidr.min.js')}} 
{{ HTML::script('assets/js/form/activity.js')}} 
{{ HTML::script('assets/js/form/calendar.js')}} 
{{ HTML::script('assets/js/form/intensity.js')}} 
{{ HTML::script('assets/js/form/time.js')}} 
{{ HTML::script('assets/js/form/submit.js')}} 
{{ HTML::script('assets/js/form/weight.js') }} 
{{ HTML::script('js/charts/chart.js')}} 
{{ HTML::script('js/charts/dark-theme.js')}}

<script type="text/javascript">
teamChart(); // start donut chart

// Reward Filter
$('.activity-type input[type=radio]').on('change', function(e) {
    var value = $("input[name='filter']:checked").val()
    $.get("/activity-filter/" + value, function(data) {
        $('.recentActivity').html(data);
        jQuery("abbr.timeago").timeago();
    });
});
</script>
@stop