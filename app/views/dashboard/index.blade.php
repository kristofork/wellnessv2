@extends('layouts.master') 

@section('content')

<div class="main-row">
    <div class="col-md-8" id="dash-nav">
        <ul class="nav tabs">

            <li class="active">
                <a href="#activity" data-toggle="tab">
                    <span class="hidden-xs">Stats</span>
                    <span class="glyphicon glyphicon-stats"></span>
                </a>
            </li>
            <li class="">
                <a href="#log" data-toggle="tab">
                    <span class="hidden-xs">Log</span>
                    <span class="glyphicon glyphicon-time"></span>
                </a>
            </li>
            <li class="">
                <a href="#" data-toggle="" class="disabled">
                    <span class="hidden-xs">Running</span>
                    <span class="glyphicon glyphicon-lock"></span>
                </a>
            </li>
            <li class="last">
                <a href="#" data-toggle="" class="disabled">
                    <span class="hidden-xs">Weight</span>
                    <span class="glyphicon glyphicon-lock"></span>
                </a>
            </li>

            <li class="">
                <a href="#" data-toggle="" class="disabled">
                    <span class="hidden-xs">Water</span>
                    <span class="glyphicon glyphicon-lock"></span>
                </a>
            </li>
            <li class="">
                <a href="#" data-toggle="" class="disabled">
                    <span class="hidden-xs">Pedometer</span>
                    <span class="glyphicon glyphicon-lock"></span>
                </a>
            </li>
            <li class="">
                <a href="#" data-toggle="" class="disabled">
                    <span class="hidden-xs">Goal</span>
                    <span class="glyphicon glyphicon-lock"></span>
                </a>
            </li>
            <li class="last">
                <a href="#" data-toggle="" class="disabled">
                    <span class="hidden-xs">Team</span>
                    <span class="glyphicon glyphicon-lock"></span>
                </a>
            </li>

        </ul>
        <!-- Nav tabs -->
    </div>
    @if(Session::has('message'))
    <div id="dash-side-right" class="alert alert-custom">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <p>{{Session::get('message') }}</p>
    </div>
    @endif


    <div id="welcome_recent_activity" class="col-md-8 tab-content" style="height:200px;">
        <!-- Tab panes -->
        <div class="tab-pane active fluid-container" id="activity">
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
                    <div class="row" id="stats_profile_name">
                        <h5>{{$name['first_name']}} {{$name['last_name']}}</h5>
                    </div>
                    <div class="row" id="stats_profile_image">
                        <div id="img-container">
                            <img class="img-circle" id="stats_profileImg" src='{{$pic}}'>
                        </div>
                        <div id="stats-container">
                            <span id="label">{{ $user_title }}</span>
                            <span id="points">{{$user_points}}/{{$required_points}}</span>
                        </div>
                        <span id="stats-progress">
                            <div id="progress">
                                <div class="bar progress-high" id="team-reward" style="text-align:left;color:#000;width:{{ percentageRound($required_points,$user_points) }}%">{{ percentageRound($required_points,$user_points) }}%</div>
                            </div>
                        </span>
                    </div>
                    <div class="row" id="stats_profile_date">
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
        <div class="tab-pane" id="log">
            <form id="activity_form" name="activity_form" method="post">
                 <div id="logInputRow" class="row">
                        <!-- Spinner Start -->
                          <div class="center">
                              <div class="bouncywrap">
                              
                                    <div class="dotcon dc1">
                                    <div class="dot"></div>
                                    </div>
                              
                                    <div class="dotcon dc2">
                                    <div class="dot"></div>
                                    </div>
                              
                                    <div class="dotcon dc3">
                                    <div class="dot"></div>
                                    </div>
                              
                              </div>
                          </div>
                            <!-- Spinner Stop -->
                    <div class="col-md-offset-1 col-md-8 col-sm-12 col-xs-12">
                            <input id="activity_text_input" name="activity_name" type="text" class="form-control" placeholder="Activity" />
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <button id="submitact" type="submit" class="btn btn-info btn-block">Submit</button>

                        </div>
                        <div id="timeSliderContainer" class="col-md-offset-1 col-md-8 col-sm-12 col-xs-12">
                            <div id="time_slider2" class="custom-slide"></div>
                            <input id="time_val" type="hidden" name="activity_time" />
                        </div>
                        <div id="timeSliderContainer" class="col-md-2">
                            <div class="summary_item">Time:
                                <span id="time_value"></span>
                            </div>
                            
                        </div>
                </div>
                <!-- End of Row -->
                 <div id="logDataRow" class="row">
                     <div class="col-md-3 logDataCol">
                        <span id="day" title="Total amount of hours logged on for the current day selected">0:00</span>
                        <span>day |</span>
                        <span id="week" title="Total amount of hours logged on for the current week selected">0:00</span>
                        <span>week</span>   
                     </div>  
                     <div class="col-md-3 logDataCol">
                        <div class="summary_item"><input type="hidden" id="datepicker" name="actdate" />
                            <span id="date_value" title="Date selected">Today</span>
                        </div>
                     </div>

                     <div class="col-md-3 logDataCol">
                        <div class="btn-group-xs intensity" data-toggle="buttons" title="Intensity of activity">
                            <label class="btn low">
                                <input type="radio" name="actintensity" id="intLow" value="1">
                                <span class="glyphicon glyphicon-fire" style="color:yellow"></span>
                            </label>
                            <label class="btn moderate active">
                                <input type="radio" name="actintensity" id="intMod" value="2">
                                <span class="glyphicon glyphicon-fire" style="color:orange"></span>
                            </label>
                            <label class="btn high">
                                <input type="radio" name="actintensity" id="intHigh" value="3">
                                <span class="glyphicon glyphicon-fire" style="color:red"></span>
                            </label>
                        </div>
                     </div>
                     <div class="col-md-3 logDataCol">
                        <div id="points" class="summary_item" title="Total amount of points for entered activity">Points:
                            <span id="points_value">2</span>
                        </div>
                     </div>
                        
                        <input id="points_hidden" size="2" name="factpt" type="hidden" />

                    
                </div>
                <!-- End of Row -->
            </form>
        </div>
        <div class="tab-pane" id="running">
            <form id="activity_form" name="activity_form" method="post">
                <div class="logSide-container">
                    <ul id="navSide">
                        <li id="header">
                            <img src="assets/img/site/runner.png" alt="">
                        </li>
                        <li id="timeContainer">
                            <span id="day">0:00</span>
                            <span>Day Total</span>
                        </li>
                        <li id="timeContainer">
                            <span id="week">0:00</span>
                            <span>Week Total</span>
                        </li>
                    </ul>
                </div>
                <div id="datepicker-container">
                    <div id="datepicker-center">
                        <div id="datepicker-running"></div>
                    </div>
                </div>
                <div class="log-row col-md-offset-2 col-md-6">
                    <div class="col-md-9">
                        <div class="">Activity -
                            <span id="date_value">Today</span>
                            <input type="hidden" id="activity_datepicker" name="actdate" />
                            <span class="glypicon glyphicon-date"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div id="points" class="summary_item">Points:
                            <span id="points_value">2</span>
                        </div>
                    </div>
                </div>

                <div class="log-row col-md-offset-2 col-md-6">
                    <div class="col-md-12">
                        <input id="activity_text_input" name="activity_name" type="text" class="form-control" placeholder="Activity" />
                    </div>
                </div>
                <div class="log-row col-md-offset-2 col-md-6">
                    <div class="col-md-6">
                        <div class="summary_item">Time:
                            <span id="time_value">00:15:00</span>
                        </div>
                        <input id="time_val" type="hidden" name="activity_time" />
                        <div id="time_slider" class="custom-slide"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="summary_item">Intensity:</div>

                        <div class="btn-group-container">
                            <div class="btn-group intensity" data-toggle="buttons">
                                <label class="btn btn-primary">
                                    <input type="radio" name="actintensity" id="intLow" value="1">
                                    <span class="glyphicon glyphicon-fire" style="color:yellow"></span>
                                </label>
                                <label class="btn btn-primary active">
                                    <input type="radio" name="actintensity" id="intMod" value="2">
                                    <span class="glyphicon glyphicon-fire" style="color:orange"></span>
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="actintensity" id="intHigh" value="3">
                                    <span class="glyphicon glyphicon-fire" style="color:red"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <input id="points_hidden" size="2" name="factpt" type="hidden" />
                <div class="log-row col-md-offset-2 col-md-6">
                    <div class="col-md-12">
                        <button id="submitact" type="submit" class="btn btn-info btn-block">Submit</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="tab-pane" id="weight">
            <ul class="nav nav-list">
                <li class="nav-header">My goals</li>
                @foreach($goals as $goal)
                <li class="goal-status">
                    <div id="statusContainer">{{ $goal->goal_name }}</div>
                    <div class="progress" id="progressContainer">
                        <div class="bar" style="width: {{ percentageRound($goal->goal, $goal->progress); }}%">{{ ounceToPounds($goal->progress); }}</div>
                    </div>
                </li>
                <li class="goal-details">
                    <div id="goalcurrent">Current: {{ounceToPounds($goal->progress);}}</div>
                    <div id="goalamount">Goal: {{ounceToPounds($goal->goal)}}</div>
                </li>
                <form id="goal_form" name="goal_form" method="post">
                    <div class="summary_item">Weight:
                        <span id="weight_value">0 lb(s) 1 oz</span>
                    </div>
                    <input id="weight_val" type="hidden" name="goalweight" />
                    <div id="weight_slider"></div>
                    <div id="submitgoal_row">
                        <button id="goalsubmit" type="submit" class="btn btn-info">Submit</button>
                    </div>

                </form>
                @endforeach
            </ul>
        </div>

    </div>
    <!-- Start of Sidebar Right -->
    <div id="dash-side-right" class="hidden-sm hidden-xs">
        <div id="donutChart" class="sidebar-right"></div>

        <div class="sidebar-right">

            <h4 id="sidebar-heading">Reward Progress</h4>
            <div class="sidebar-padding">
                @foreach($rewards as $reward)
                <div class="progress-item col-md-12">
                    <div style="font-size:15px; text-align:center">{{$hoursToReward['name']}}</div>
                    <div style="text-align:center; font-size:10px;">Expires in @if(deadlineCount( date("Y/m/d") ,$reward->deadline)
                        < 30) <span style="color:red">{{deadlineCount( date("Y/m/d") ,$reward->deadline)}}</span>
                            @elseif(deadlineCount( date("Y/m/d") ,$reward->deadline) >= 30 && deadlineCount( date("Y/m/d") ,$reward->deadline)
                            < 60 ) <span style="color:yellow">{{deadlineCount( date("Y/m/d") ,$reward->deadline)}}</span>
                                @else
                                <span style="color:#5f5">{{deadlineCount( date("Y/m/d") ,$reward->deadline)}}</span>
                                @endif days
                    </div>
                    <div>{{round($user_time / 60 / 60, 1)}} total hours out of {{$reward->milestone /60 / 60}}</div>
                    <div class="progress">
                        <div class="bar" id="reward" style="width: {{ percentageRound($reward1->milestone, $user_time); }}%">{{ percentageRound($reward->milestone, $user_time); }}%</div>
                    </div>
                    <span>Average {{$hoursToReward['time']}} per day to complete this goal</span>
                </div>
                @endforeach

            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <!-- End of Sidebar Right-->
    <!-- Start of Recent Activity (middle column) -->
    <div class="col-md-8" id="welcome_recent_activity">
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
