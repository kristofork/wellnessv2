@extends('layouts.lite') 

@section('content')


   

    <div class="row-centered table-container" style="position:relative;">
    <div id="activity" class="col-centered masthead tablecell-container" style="height:250px;">
       <div class="tint">
           <div class="" id="stats_profile_image">
            <div id="img-container">
                <img class="img-circle" id="stats_profileImg" src='{{$pic}}'>
            </div>
           </div>

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

@stop
