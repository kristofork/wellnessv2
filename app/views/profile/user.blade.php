@extends('layouts.lite') @section('content')

<style>
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}
    
.grid path,
.grid line {
  fill: none;
  stroke: rgba(0, 0, 0, 0.15);
  shape-rendering: crispEdges;
}


.line {
  fill: none;
  stroke-width: 2.5px;
}
.tick .text {
    font-size:12px;
}
.tick line {
      opacity: 0.2;
}
    
div.tooltip {
	position: absolute;
	text-align: center;
	width: 80px;
	height: 40px;
	padding: 2px;
	font: 12px sans-serif;
	background: #eee;
	border: 1px solid #ccc;
	border-radius: 8px;
	pointer-events: none;
	
}

#chart-container{
    font-size:.5em;
}    
    .svg-container {
    display: block;
    position: relative;
    width: 90%;
    margin: 0 auto;
    vertical-align: top;
    overflow: ;
}

</style>

    <div class="row-centered table-container" style="position:relative;">
    <div id="activity" class="col-centered masthead tablecell-container" style="height:250px;">
       <div class="tint">
       <div id="recent_activity_container" class="col-centered col-md-5" style="margin:5px auto; display:block;">
       
        <div id="chart-container"></div>
        </div>

    </div> <!-- End of Tint -->
    </div>
</div>   
   
   
    <!-- Start of Recent Activity (middle column) -->
    <div class="row-centered" style="position:relative;">
    <div class="col-centered col-md-8" id="welcome_recent_activity">
       
        <h2>Recent Activity</h2>
    </div>
        <ul class="recentActivity">
            @include('_partials.activityfeed')
        </ul>
    </div>
    <!-- Start of Sidebar Right 
    <div id="dash-side-right">

        <div class="sidebar-right">
            <ul class="nav nav-list" id="fav-activity">
                <h4 id="sidebar-heading">Favorite Activity</h4>
                @foreach ($fav_activities as $favs)
                <li>{{ $favs->activity_name }}</li>
                @endforeach

            </ul>
            <div style="clear: both"></div>
        </div>
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
                        <div class="bar" id="reward" style="width: {{ percentageRound($reward->milestone, $user_time,0); }}%">{{ percentageRound($reward->milestone, $user_time,0); }}%</div>
                    </div>
                    <span>Average {{$hoursToReward['time']}} per day to complete this goal</span>
                </div>
                @endforeach

            </div>
            <div style="clear: both"></div>
        </div>
    </div>
    End of Sidebar Right-->

{{ HTML::script('assets/js/progressbars.js')}} 
{{ HTML::script('assets/js/jquery.hoverIntent.minified.js')}} 
{{ HTML::script('assets/js/highcharts/highcharts.js')}} 
{{ HTML::script('assets/js/highcharts/modules/exporting.js')}} 
{{ HTML::script('js/charts/chart.js')}} 
{{ HTML::script('js/charts/dark-theme.js')}} 
{{ HTML::script('assets/js/d3.js') }}

<script type="text/javascript">
    activityChart();
</script>

@stop