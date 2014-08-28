@extends('layouts.master')



@section('content')


<div class="main-row">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8" id="dash-nav">
                <ul class="nav tabs">
                <li class="active"><a href="#activity" data-toggle="tab"><span class="hidden-xs">Stats </span><span class="glyphicon glyphicon-stats"></span> </a></li>
                <li><a href="#log" data-toggle="tab"><span class="hidden-xs">Log </span><span class="glyphicon glyphicon-calendar"></span> </a></li>
                <li><a href="#" data-toggle="" class="disabled"><span class="hidden-xs">Running </span><span class="glyphicon glyphicon-lock"></span></a></li>
                <li><a href="#" data-toggle="" class="disabled"><span class="hidden-xs">Weight </span><span class="glyphicon glyphicon-lock"></span></a></li>
                <li><a href="#" data-toggle="" class="disabled"><span class="hidden-xs">Water </span><span class="glyphicon glyphicon-lock"></span></a></li>
                <li><a href="#" data-toggle="" class="disabled"><span class="hidden-xs">Pedometer </span><span class="glyphicon glyphicon-lock"></span></a></li>
                <li><a href="#" data-toggle="" class="disabled"><span class="hidden-xs">Goal </span><span class="glyphicon glyphicon-lock"></span></a></li>
                <li><a href="#" data-toggle="" class="disabled"><span class="hidden-xs">Team </span><span class="glyphicon glyphicon-lock"></span></a></li>
                </ul>
                <!-- Nav tabs -->
            </div>
            @if(Session::has('message'))
            <div id="dash-side-right" class="alert alert-success" style="width:29%">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p>{{Session::get('message') }} </p>
            </div>
            @endif

        </div>
    </div>


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
                            <span id="label">{{ $user_title }}</span><span id="points">{{$user_points}}/{{$required_points}}</span>
                        </div>
                        <span id="stats-progress">
                            <div id="progress"><div class="bar progress-low" id = "team-reward" style="width:10%">10%</div></div>
                        </span>  
                    </div>  
                    <div class="row" id="stats_profile_date">
                        <h6>Active member since 2010</h6>
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
                    <div class="logSide-container container-fluid">
                    <ul id ="navSide" class="time-list">
                        <li id="header"><span class="glyphicon glyphicon-time"></span></li>
                        <li id="timeContainer"><span id="day">0:00</span><span>Day Total</span></li>
                        <li id="timeContainer"><span id="week">0:00</span><span>Week Total</span> </li>
                    </ul>
                    </div>
                    <div id="datepicker-container" class="hidden-xs">
                        <div id="datepicker-center">
                            <div id="datepicker"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="log-row col-md-offset-2 col-md-6 col-sm-offset-2 col-sm-6 col-xs-offset-3 col-xs-9">
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <div class="summary_item">Date: <span id="date_value">Today</span>
                                    <input type="hidden" id="activity_datepicker" name="actdate" />
                                    <span class="glypicon glyphicon-date"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div id="points" class="summary_item">Points: <span id="points_value">2</span></div>
                            </div>
                        </div>

                        <div class="log-row col-md-offset-2 col-md-6 col-sm-offset-2 col-sm-6 col-xs-offset-3 col-xs-6">
                           <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input id="activity_text_input" name="activity_name" type="text" class="form-control" placeholder="Activity" />
                            </div> 
                        </div>
                        <div class="log-row col-md-offset-2 col-md-6 col-sm-offset-2 col-sm-6 col-xs-offset-3 col-xs-9">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="summary_item">Time: <span id="time_value">00:15:00</span></div>
                                    <input id="time_val" type="hidden" name="activity_time" />
                                    <div id="time_slider" class="custom-slide"></div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="summary_item">Intensity:</div>
                                
                                    <div class="btn-group-container">
                                        <div class="btn-group intensity" data-toggle="buttons">
                                          <label class="btn btn-primary">
                                            <input type="radio" name="actintensity" id="intLow" value="1"> <span class="glyphicon glyphicon-fire" style="color:yellow"></span>
                                          </label>
                                          <label class="btn btn-primary active">
                                            <input type="radio" name="actintensity" id="intMod" value="2" > <span class="glyphicon glyphicon-fire" style="color:orange"></span>
                                          </label>
                                          <label class="btn btn-primary">
                                            <input type="radio" name="actintensity" id="intHigh" value="3"> <span class="glyphicon glyphicon-fire" style="color:red"></span>
                                          </label>
                                        </div>
                                    </div>
                                </div>

                        </div>

                        <input id="points_hidden" size="2" name="factpt" type="hidden" />
                        <div class="log-row col-md-offset-2 col-md-6 col-sm-offset-2 col-sm-6 col-xs-offset-3 col-xs-6">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <button id="submitact" type="submit" class="btn btn-info btn-block">Submit</button>
                            <!-- Spinner Start -->
                            <div id="escapingBallG">
                            <div id="escapingBall_1" class="escapingBallG">
                            </div>
                            </div>
                            <!-- Spinner Stop -->
                            </div>
                        </div>
                    </div><!-- End of Row -->
                </form>
          </div>
          <div class="tab-pane" id="running">
              <form id="activity_form" name="activity_form" method="post">
                    <div class="logSide-container">
                    <ul id ="navSide">
                        <li id="header"><img src="assets/img/site/runner.png" alt=""></li>
                        <li id="timeContainer"><span id="day">0:00</span><span>Day Total</span></li>
                        <li id="timeContainer"><span id="week">0:00</span><span>Week Total</span> </li>
                    </ul>
                    </div>
                    <div id="datepicker-container">
                      <div id="datepicker-center">
                            <div id="datepicker-running"></div>
                          </div>
                        </div>  
                    <div class="log-row col-md-offset-2 col-md-6">
                        <div class="col-md-9">
                            <div class="">Activity - <span id="date_value">Today</span>
                                <input type="hidden" id="activity_datepicker" name="actdate" />
                                <span class="glypicon glyphicon-date"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="points" class="summary_item">Points: <span id="points_value">2</span></div>
                        </div>
                    </div>

            <div class="log-row col-md-offset-2 col-md-6">
                <div class="col-md-12">
                        <input id="activity_text_input" name="activity_name" type="text" class="form-control" placeholder="Activity" />
                </div> 
            </div>
            <div class="log-row col-md-offset-2 col-md-6">
                    <div class="col-md-6">
                        <div class="summary_item">Time: <span id="time_value">00:15:00</span></div>
                        <input id="time_val" type="hidden" name="activity_time" />
                        <div id="time_slider" class="custom-slide"></div>
                    </div>
                    <div class="col-md-6">
                    <div class="summary_item">Intensity:</div>
                    
                        <div class="btn-group-container">
                            <div class="btn-group intensity" data-toggle="buttons">
                              <label class="btn btn-primary">
                                <input type="radio" name="actintensity" id="intLow" value="1"> <span class="glyphicon glyphicon-fire" style="color:yellow"></span>
                              </label>
                              <label class="btn btn-primary active">
                                <input type="radio" name="actintensity" id="intMod" value="2" > <span class="glyphicon glyphicon-fire" style="color:orange"></span>
                              </label>
                              <label class="btn btn-primary">
                                <input type="radio" name="actintensity" id="intHigh" value="3"> <span class="glyphicon glyphicon-fire" style="color:red"></span>
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
                <li class="goal-status"><div id="statusContainer">{{ $goal->goal_name }}</div><div class="progress" id = "progressContainer"><div class="bar" style="width: {{ percentageRound($goal->goal, $goal->progress); }}%">{{ ounceToPounds($goal->progress); }}</div></div></li>
                <li class="goal-details"><div id="goalcurrent">Current: {{ounceToPounds($goal->progress);}} </div><div id="goalamount">Goal: {{ounceToPounds($goal->goal)}}</div></li>
                <form id="goal_form" name="goal_form" method="post">
                    <div class="summary_item">Weight: <span id="weight_value">0 lb(s) 1 oz</span></div>
                    <input id="weight_val" type="hidden" name="goalweight" />
                    <div id="weight_slider"></div>
                    <div id="submitgoal_row"><button id="goalsubmit" type="submit" class="btn btn-info">Submit</button></div>
                    
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
                        <div style="font-size:15px; text-align:center">{{$hoursToReward['name']}}</div> <br/>
                        <span>{{deadlineCount( date("Y/m/d") ,$reward->deadline)}} days left!</span>
                        <div class="progress">
                            <div class="bar" id = "reward" style="width: {{ percentageRound($reward1->milestone, $user_time); }}%"> {{ percentageRound($reward->milestone, $user_time); }}%</div>
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
            <div class="btn-group pull-right">
              <button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-user"></span></button>
              <button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span></button>
              <button type="button" class="btn btn-default btn-xs active"><span class="glyphicon glyphicon-globe"></span></button>
            </div>
            <ul class="recentActivity">

                @foreach($activities as $activity)
                <?php
                    $moreNamesArray = NULL;
                    $liked = NULL; // Set to default to NULL
                    $activeId = $activity->id;
                    $likeids = Activity::find($activity->id)->likeCount; // Query the amount of total likes
                        if ($likeids != 0)  // Prevents error for activities with no 'likes' in the Activity_like table
                            $liked = DB::table('activity_likes')->where('user_id',Auth::user()->id)->where('act_id',$activity->id)->pluck('user_id');  // Query to check if the currently logged in user liked the activity. 
                 ?>

                    <li id="{{$activeId}}">

                        <div class="activityBox">

                                @if ($activity->type == "time")
                                    <div class="recentActivityDesc">
                                        <div class="profilePicContainer"> 
                                            <span rel="hovercard" data-url="{{$activity->users_id}}">
                                                <div class="hovercard"></div>
                                                    {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}}
                                            </span>
                                        </div>
                                        <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                        <div class="recentActivityText">Logged {{ secondsToString(hoursToSeconds($activity->activity_time )) }} of <strong>{{ $activity->activity_name }} </strong></div>
                                    </div>
                                @elseif ($activity->type == "read")
                                    <div class="recentActivityDesc">
                                        <div class="profilePicContainer"> 
                                            {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                                        </div>
                                    <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                        <div class="recentActivityText">Read <strong>{{ $activity->activity_name }} </strong></div>
                                    </div>
                                @elseif ($activity->type == "rank")
                                    <div class="recentActivityDesc">
                                        <div class="profilePicContainer"> 
                                            {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                                        </div>
                                    <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                        <div class="recentActivityText"><strong>{{ $activity->activity_name }} </strong></div>
                                    </div>
                                @else
                                <div class="recentActivityDesc">
                                        <div class="profilePicContainer"> 
                                            {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                                        </div>
                                    <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                        <div class="recentActivityText">Lost {{ ounceToPounds($activity->goal_num ) }} last week towards their <strong>{{ $activity->activity_name }} goal </strong></div>
                                    </div>
                                @endif

                        <div class="timeContainer"><span class="glyphicon glyphicon-time"></span><abbr class="timeago" title="{{ convertTimeIso($activity->created_at) }}">&nbsp;</abbr></div>

                        <div class="activityIcon">
                            @if ($activity->type == "time")
                            {{HTML::image("/assets/img/badges/timeActivity.png", "Time Activty");}} 
                            @elseif ($activity->type == "read")
                            {{HTML::image("/assets/img/badges/readActivity.png", "Read Activty");}}
                            @else
                            {{HTML::image("/assets/img/badges/goalActivity.png", "Goal Activty");}}
                            @endif
                        </div>

                    
                   

                            @if($likeids > 0) <!-- Conditional: If no likes, skip to like button -->
                                <div class="activityLikeImg" id="{{ $activity->id }}">
                                <span class="glyphicon glyphicon-heart" style="color:#FF5566"></span>
                                <span>{{ $activity->likeCount }}</span>

                                </div>
                            @endif
                        <!--Conditional: User cannot like own activities and cannot like activities more than once -->
                        @if(Auth::user()->username != $activity->username &&  $liked == NULL)

                        <!-- Begin of test spinner -->

                          <div class="glyphicon glyphicon-heart like-heart" id='{{ $activity->id}}' title="Click to like!"></div>
                        <!-- End of test spinner -->


                        @else

                    

                        @endif
                    </div> <!-- End Activitybox-->
                </li>
                <hr class="activityHR" />
                @endforeach
                <li id ='more' class="load-more" num_loaded='10' data-icon="arrow-d">
                    <a href="#" style="text-align: center">Load More <span class="glyphicon glyphicon-chevron-down"></span></a>
                </li>
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
{{ HTML::script('js/activities/pagination.js') }}
<script type="text/javascript">
    teamChart(); // start donut chart
</script>
@stop
                                   
