
<div id="recent_activity_header" class="col-md-8 col-sm-11 col-xs-11 col-centered recentheader">   

<h3 class="recentheader">Recent Activity</h3>
        <div id="activity-type-form" class="recentheader">
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
    </div>
</div>
                @foreach($activities as $activity)
                
                <?php 
                        $liked = $activity->likes->toArray(); // returns object if current user liked the activity
                    $hasBadge = count($activity->user->badgeuser);
                    if($hasBadge){
                        $badgeuser = $activity->user->badgeuser->toArray()[0];
                        $badgelvl = $badgeuser['lvl'];
                        $badgetype = $badgeuser['type'];
                        $badgedesc = $badgeuser['desc'];
                        $flairclass ="sprite-flair_". $badgetype."_".$badgelvl;
                    }
                    $activeId = $activity->id;
                    $likeids = Activity::find($activity->id)->likeCount; // Query the amount of total likes
                        if ($likeids != 0)  // Prevents error for activities with no 'likes' in the Activity_like table

                 ?>
                <div id="recent_activity_container" class="col-md-8 col-sm-11 col-xs-11 col-centered">
                    <li id="{{$activeId}}">

                        <div class="activityBox">
                                @if ($activity->type == "time")
                                    <div class="recentActivityDesc">
                                        <div class="profilePicContainer">
                                            <span rel="hovercard" data-url="{{$activity->user->id}}">
                                                <div class="hovercard hidden-sm hidden-xs"></div>
                                                    {{HTML::image($activity->user->pic, $activity->user->first_name, array('id'=> 'profilePic'));}}
                                            </span>
                                        </div>
                                        <div class="recentActivityName hidden-sm hidden-xs">{{ $activity->user->first_name}} {{ substr($activity->user->last_name, 0, 1) }}.</div>
                                            <!-- Flair-->
                                            @if($hasBadge)
                                            <div id="container-flair"><span class="{{$flairclass}}" title="{{$badgedesc}}"></span></div>
                                            @endif
                                        <div class="recentActivityText">Logged {{ secondsToString(hoursToSeconds($activity->activity_time )) }} of <strong>{{ $activity->activity_name }} </strong>

                                        </div>
                                    </div>
                                @elseif ($activity->type == "read")
                                    <div class="recentActivityDesc">
                                        <div class="profilePicContainer"> 
                                            <span rel="hovercard" data-url="{{$activity->user->id}}">
                                                <div class="hovercard hidden-sm hidden-xs"></div>
                                                    {{HTML::image($activity->user->pic, $activity->user->first_name, array('id'=> 'profilePic'));}}
                                            </span>
                                        </div>
                                    <div class="recentActivityName hidden-sm hidden-xs">{{ $activity->user->first_name}} {{ substr($activity->user->last_name, 0, 1) }}. </div>
                                            <!-- Flair-->
                                            @if($hasBadge)
                                            <div id="container-flair"><span class="{{$flairclass}}" title="{{$badgedesc}}"></span></div>
                                            @endif
                                        <div class="recentActivityText">Read <a href="{{URL::to('blog')}}">{{ $activity->activity_name }} </a></div>
                                    </div>
                                @elseif ($activity->type == "rank")
                                    <div class="recentActivityDesc">
                                        <div class="profilePicContainer"> 
                                            <span rel="hovercard" data-url="{{$activity->user->id}}">
                                                <div class="hovercard hidden-sm hidden-xs"></div>
                                                    {{HTML::image($activity->user->pic, $activity->user->first_name, array('id'=> 'profilePic'));}}
                                            </span>
                                        </div>
                                    <div class="recentActivityName hidden-sm hidden-xs">{{ $activity->first_name}} {{ substr($activity->user->last_name, 0, 1) }}. </div>
                                            <!-- Flair-->
                                            @if($hasBadge)
                                            <div id="container-flair"><span class="{{$flairclass}}" title="{{$badgedesc}}"></span></div>
                                            @endif
                                        <div class="recentActivityText"><strong>{{ $activity->activity_name }} </strong></div>
                                    </div>
                                @else
                                <div class="recentActivityDesc">
                                        <div class="profilePicContainer"> 
                                            <span rel="hovercard" data-url="{{$activity->user->id}}">
                                                <div class="hovercard hidden-sm hidden-xs"></div>
                                                    {{HTML::image($activity->user->pic, $activity->user->first_name, array('id'=> 'profilePic'));}}
                                            </span>
                                        </div>
                                    <div class="recentActivityName hidden-sm hidden-xs">{{ $activity->user->first_name}} {{ substr($activity->user->last_name, 0, 1) }}. </div>
                                            <!-- Flair-->
                                            @if($hasBadge)
                                            <div id="container-flair"><span class="{{$flairclass}}" title="{{$badgedesc}}"></span></div>
                                            @endif
                                        <div class="recentActivityText">{{ $activity->activity_name }} </strong></div>
                                    </div>
                                @endif
                            
                            <div class="activityStatsContainer">
                                <div class="timeContainer">
                                    <span class="glyphicon glyphicon-time" style="color:#55ffb6"></span>
                                    <abbr class="timeago" title="{{ convertTimeIso($activity->created_at) }}"></abbr>
                                </div>
                                <!--Conditional: User cannot like own activities and cannot like activities more than once -->
                                @if(Auth::user()->username != $activity->user->username &&  count($liked) < 1)
                                <div class="toLikeImg">
                                <div class="glyphicon glyphicon-heart like-heart" id='{{ $activity->id}}' title="Click to like!"></div>   
                                </div>
                                @else
                                <div class="activityLikeImg" id="{{ $activity->id }}">
                                    <span class="glyphicon glyphicon-heart" style="color:#F563A1"></span>
                                    <span class="like-count">&nbsp;{{ $activity->likeCount }}</span>
                                </div>                                
                                @endif
                            </div>

                        <div class="activityIcon hidden-sm hidden-xs">
                            @if ($activity->type == "time")
                            {{HTML::image("/assets/img/badges/timeActivity.png", "Time Activty");}} 
                            @elseif ($activity->type == "read")
                            {{HTML::image("/assets/img/badges/readActivity.png", "Read Activty");}}
                            @else
                            {{HTML::image("/assets/img/badges/goalActivity.png", "Goal Activty");}}
                            @endif
                        </div>

                    </div> <!-- End Activitybox-->
                </li>
                
</div>
                @endforeach
                
                <li id ='more' class="load-more" num_loaded='10' data-icon="arrow-d">
                    <a href="" style="text-align: center">Load More <span class="glyphicon glyphicon-chevron-down"></span></a>
                </li>
                