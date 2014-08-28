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
                                    {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}}
                                    </span>
                                </div>
                                <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach

                                <div class="recentActivityText">Logged {{ secondsToString(hoursToSeconds($activity->activity_time )) }} of <strong>{{ $activity->activity_name }} </strong></div>
                            </div>
                            @elseif ($activity->type == "read")
                            <div class="recentActivityDesc">
                                    <div class="profilePicContainer"> 
                                        {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                                    </div>
                                <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach
                                <div class="recentActivityText">Read <strong>{{ $activity->activity_name }} </strong></div>
                            </div>
                            @else
                            <div class="recentActivityDesc">
                                <div class="profilePicContainer"> 
                                    {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                                </div>
                                <div class="recentActivityName">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                                @foreach($badges as $badge)
                                    {{HTML::image($badge->image . "-sm.png", 'test', array('class'=> 'badge-small', 'title'=> $badge->name));}}
                                @endforeach                    
                                <div class="recentActivityText">Lost {{ ounceToPounds($activity->goal_num ) }} last week towards their <strong>{{ $activity->activity_name }} goal </strong></div>
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
                        @if(Auth::user()->username != $activity->username &&  $liked == NULL)

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
    <div style="width:31%; float:left; margin-top:5px;">

        <div class="sidebar-right">
            <ul class="nav nav-list">
                <h4 id="sidebar-heading">Favorite Activities</h4>
                @foreach ($fav_activities as $favs)
                <li>{{ $favs->activity_name }} </li>
                @endforeach

            </ul>
            <div style="clear: both"></div>
        </div>        
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

</div>
{{ HTML::script('assets/js/progressbars.js')}}
{{ HTML::script('assets/js/jquery.hoverIntent.minified.js')}}
{{ HTML::script('assets/js/highcharts/highcharts.js')}}
{{ HTML::script('assets/js/highcharts/modules/exporting.js')}}
{{ HTML::script('js/charts/chart.js')}}
{{ HTML::script('js/charts/dark-theme.js')}}

<script type="text/javascript">
  activityChart();
</script>

@stop