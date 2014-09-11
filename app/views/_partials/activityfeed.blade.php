                
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
                    <a href="" style="text-align: center">Load More <span class="glyphicon glyphicon-chevron-down"></span></a>
                </li>
                {{ HTML::script('js/activities/pagination.js') }}