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
                                <div class="bar progress-high" id="team-reward" style="text-align:left;color:#000;width:{{ percentageRound($required_points,$user_points,$point_difference) }}%">{{ percentageRound($required_points,$user_points,$point_difference) }}%</div>
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
        <div id="userData" class="row">
            <div class="col-md-4 col-sm-4 col-xs-4">
            <span style="line-height:2.6em">{{$teamname}}</span> 
           </div>
           <div class="col-md-4 col-sm-4 col-xs-4" style="text-align:center">
           <span>{{ $user_title }}</span> 
            <span id="stats-progress">
            <div id="progress">
                <div class="bar progress-high" id="team-reward" style="text-align:left;color:#000;width:{{ percentageRound($required_points,$user_points,$point_difference) }}%">{{ percentageRound($required_points,$user_points, $point_difference) }}%</div>
            </div>

           </span>
           </div>
           <div class="col-md-4 col-sm-4 col-xs-4">
               @foreach($rewards as $reward)
                <div style="text-align:center; font-size:1em; line-height:2.6em;">
                       @if(deadlineCount( date("Y/m/d") ,$reward->deadline)< 30)
                            <span style="color:red">{{deadlineCount( date("Y/m/d") ,$reward->deadline)}}</span>
                        @elseif(deadlineCount( date("Y/m/d") ,$reward->deadline) >= 30 && deadlineCount( date("Y/m/d") ,$reward->deadline)< 60 )
                            <strong style="color:#F05912">{{deadlineCount( date("Y/m/d") ,$reward->deadline)}}</strong>
                        @else
                            <span style="color:#5f5">{{deadlineCount( date("Y/m/d") ,$reward->deadline)}}</span>
                        @endif 
                        days left
                </div>
                @endforeach
           </div>
           
       </div>
    </div> <!-- End of Tint -->
    </div>
</div>
   <div id="dashDataRow" class="">
        <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
            <span id="likeCount" class="glyphicons glyphicons-heart"></span>
            <div class="likes" id="glyph-text" data-count="{{$user_like_count}}">{{$user_like_count}}</div>  
        </div> 
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        <span id="rankCount" class="glyphicons glyphicons-stats"></span>
            <div id="glyph-text">{{$user_rank}} of {{$user_count}}</div> 
     </div>
    @foreach($rewards as $reward)
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        <span id="timeCount" class="glyphicons glyphicons-stopwatch"></span>
        <div id="glyph-text">{{round($user_time / 60 / 60, 1)}} of {{$reward->milestone /60 / 60}}</div> 
     </div>
     @endforeach
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        <span id="teamrankCount" class="glyphicons glyphicons-group"></span>
        <div id="glyph-text">
        @if ($teamname != "Individuals")
            <span>{{$team_rank}} of {{$team_count}}</span>
        @else
            <span>0 of 0</span>
        @endif
        </div> 
     </div>
    </div>
    <!-- Start of Recent Activity (middle column) -->
    <div class="row-centered" style="position:relative;">
        <ul class="recentActivity">
            @include('_partials.activityfeed')
        </ul>
    
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

{{ HTML::script('js/charts/chart.js')}} 
{{ HTML::script('js/charts/dark-theme.js')}}
{{ HTML::script('assets/js/form/type.js')}}
<script type="text/javascript">
teamChart(); // start donut chart

</script>
@stop
