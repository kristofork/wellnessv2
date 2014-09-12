@foreach($activities as $activity)
	<li id="" style="display:none">
        <div class="activityBox">

                @if ($activity->type == "time")
                    <div class="recentActivityDesc">
                        <div class="profilePicContainer"> 
                            <span rel="hovercard" data-url="{{$activity->users_id}}">
                                <div class="hovercard hidden-sm hidden-xs"></div>
                                    {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}}
                            </span>
                        </div>
                        <div class="recentActivityName hidden-sm hidden-xs">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                        <div class="recentActivityText">Logged {{ secondsToString(hoursToSeconds($activity->activity_time )) }} of <strong>{{ $activity->activity_name }} </strong></div>
                    </div>
                @elseif ($activity->type == "read")
                    <div class="recentActivityDesc">
                        <div class="profilePicContainer"> 
                            {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                        </div>
                    <div class="recentActivityName hidden-sm hidden-xs">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                        <div class="recentActivityText">Read <strong>{{ $activity->activity_name }} </strong></div>
                    </div>
                @elseif ($activity->type == "rank")
                    <div class="recentActivityDesc">
                        <div class="profilePicContainer"> 
                            {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                        </div>
                    <div class="recentActivityName hidden-sm hidden-xs">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                        <div class="recentActivityText"><strong>{{ $activity->activity_name }} </strong></div>
                    </div>
                @else
                <div class="recentActivityDesc">
                        <div class="profilePicContainer"> 
                            {{HTML::image($activity->pic, $activity->first_name, array('id'=> 'profilePic'));}} 
                        </div>
                    <div class="recentActivityName hidden-sm hidden-xs">{{ $activity->first_name}} {{ substr($activity->last_name, 0, 1) }}. </div>
                        <div class="recentActivityText">Lost {{ ounceToPounds($activity->goal_num ) }} last week towards their <strong>{{ $activity->activity_name }} goal </strong></div>
                    </div>
                @endif

        <div class="timeContainer"><span class="glyphicon glyphicon-time"></span><abbr class="timeago" title="{{ convertTimeIso($activity->created_at) }}">&nbsp;</abbr></div>

        <div class="activityIcon hidden-sm hidden-xs">
            @if ($activity->type == "time")
            {{HTML::image("/assets/img/badges/timeActivity.png", "Time Activty");}} 
            @elseif ($activity->type == "read")
            {{HTML::image("/assets/img/badges/readActivity.png", "Read Activty");}}
            @else
            {{HTML::image("/assets/img/badges/goalActivity.png", "Goal Activty");}}
            @endif
        </div>

            @if($activity->likeCount > 0) <!-- Conditional: If no likes, skip to like button -->
                <div class="activityLikeImg" id="{{ $activity->id }}">
                <span class="glyphicon glyphicon-heart" style="color:#FF5566"></span>
                <span>{{ $activity->likeCount }}</span>
                </div>
            @endif

    </div> <!-- End Activitybox-->
</li>
@endforeach