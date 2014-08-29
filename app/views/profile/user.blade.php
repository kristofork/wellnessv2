@extends('layouts.master')

@section('content')
<div class="main-row">
        <div id="container" class="col-md-12" style="height:300px;margin-bottom:5px;"></div>
        <!-- Start of Recent Activity (middle column) -->
        <div class="col-md-8" id="welcome_recent_activity">
            <h2>Recent Activity</h2>
            <ul class="recentActivity">
                @include('_partials.activityfeed');
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