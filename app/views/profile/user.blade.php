@extends('layouts.master')

@section('content')
<div class="main-row">
        <div id="container" class="col-md-12" style="height:300px;"></div>
        <!-- Start of Recent Activity (middle column) -->
        <div class="col-md-8" id="welcome_recent_activity">
            <h2>Recent Activity</h2>
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
                        <?php $badges = DB::table('badge_user')->join('badges', 'badges.id', '=', 'badge_user.badge_id')->where('user_id', $activity->users_id)->get(array('badges.name', 'badges.desc', 'badges.image')) ?>

                        @if ($activity->type == "time")
                            <div class="recentActivityDesc">
                                <div class="profilePicContainer"> 
                                    <span rel="hovercard" data-url="{{$activity->users_id}}">
                                        <div class="hovercard"></div>
                                    {{HTML::image($activity->pic, $activity->userfirst, array('id'=> 'profilePic'));}}
                                    </span>
                                </div>
                                <div class="recentActivityName">{{ $activity->userfirst}} {{ substr($activity->userlast, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach

                                <div class="recentActivityText">Logged {{ secondsToString(hoursToSeconds($activity->acttime )) }} of <strong>{{ $activity->actname }} </strong></div>
                            </div>
                            @elseif ($activity->type == "read")
                            <div class="recentActivityDesc">
                                    <div class="profilePicContainer"> 
                                        {{HTML::image($activity->pic, $activity->userfirst, array('id'=> 'profilePic'));}} 
                                    </div>
                                <div class="recentActivityName">{{ $activity->userfirst}} {{ substr($activity->userlast, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach
                                <div class="recentActivityText">Read <strong>{{ $activity->actname }} </strong></div>
                            </div>
                            @else
                            <div class="recentActivityDesc">
                                <div class="profilePicContainer"> 
                                    {{HTML::image($activity->pic, $activity->userfirst, array('id'=> 'profilePic'));}} 
                                </div>
                                <div class="recentActivityName">{{ $activity->userfirst}} {{ substr($activity->userlast, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach                    
                                <div class="recentActivityText">Lost {{ ounceToPounds($activity->goal_num ) }} last week towards their <strong>{{ $activity->actname }} goal </strong></div>
                            </div>
                            @endif
                            
                            <div class="timeContainer"><abbr class="timeago" title="{{ convertTimeIso($activity->created_at) }}">&nbsp;</abbr></div>
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
                        @if(Auth::user()->username != $activity->userName &&  $liked == NULL)

                        <!-- Begin of test spinner -->

                          <div class="applaud" id='{{ $activity->id}}'>
                            <div class="ui-spinner">
                              <span class="side side-left">
                                <span class="fill"></span>
                              </span>
                              <span class="side side-right">
                                <span class="fill"></span>
                              </span>
                            </div>
                          </div>
                        <!-- End of test spinner -->


                        @else

                    

                        @endif
                    </div> <!-- End Activitybox-->
                </li>
                <hr class="activityHR" />
                @endforeach
            </ul>
        </div>

        <!-- Start of Sidebar Right -->
    <div style="width:31%; float:left; margin-top:15px;">
        <div id="donutChart" class="sidebar-nav well well-small"> 

        </div>
        <div class=" sidebar-nav well well-small">
            <ul class="nav nav-list">
                <li class="nav-header">Favorite Activities</li>

                @foreach ($fav_activities as $favs)
                <li>{{ $favs->actName }} </li>
                @endforeach

            </ul>
            <div style="clear: both"></div>
        </div>        
        <div class="sidebar-right">
            <h4 id="sidebar-heading">Reward Progress</h4>
            <div class="sidebar-padding">
                @foreach($rewards as $reward)
                @if(sizeof($rewards) < 1)
                    <div class="progress-item col-md-12">
                        <div style="font-size:60px; text-align:center">1</div> <br/>
                        <span>{{deadlineCount( date("Y/m/d") ,$reward->deadline)}} days left!</span>
                        <div class="progress">
                            <div class="bar" id = "reward" style="width: {{ percentageRound($reward1->milestone, $user->userTotalHrs); }}%"> {{ percentageRound($reward->milestone, $user->userTotalHrs); }}%</div>
                        </div>
                    </div>
                @else
                    <div class="progress-item col-md-6">
                        <div style="font-size:60px; text-align:center">{{$reward->id}}</div> <br/>
                        <span>{{deadlineCount( date("Y/m/d") ,$reward->deadline)}} days left!</span>
                        <div class="progress">
                            <div class="bar" id = "reward" style="width: {{ percentageRound($reward->milestone, $user->userTotalHrs); }}%"> {{ percentageRound($reward->milestone, $user->userTotalHrs); }}%</div>
                        </div>
                    </div>                
                @endif
                @endforeach


            </div>
                <div style="clear: both"></div> 
        </div>
    </div>
    <!-- End of Sidebar Right-->

</div>
{{ HTML::script('assets/js/progressbars.js')}}
{{ HTML::script('assets/js/jquery.hoverIntent.minified.js')}}
{{ HTML::script('assets/js/highcharts/highcharts.js')}}
{{ HTML::script('assets/js/highcharts/modules/exporting.js')}}

        <script>
        //Ajax User Activity
function activityChart() {
    $.ajax({
        type: "GET",
        url: "/user-activity",
        success: function(json) {
            chart = new Highcharts.Chart({
                credits: {
                    enabled: false
                },
                chart: {
                    renderTo: 'container',
                    type: 'line',
                    marginRight: 130,
                    marginBottom: 25
                },
                title: {
                    text: 'Activity Time',
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Hours'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                            this.x + ': ' + this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
                series: json
            });
        }
    });
}
        activityChart();
        </script>
@stop