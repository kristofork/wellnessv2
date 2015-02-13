@extends('layouts.lite') @section('content')

<?php $today = new DateTime(); ?>
         
       @if(Session::has('message'))
    <div id="dash-side-right" class="alert alert-custom">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <p>{{Session::get('message') }}</p>
    </div>
        @elseif($errors->has())
    <div id="dash-side-right" class="alert alert-custom">
        <button type="button" class="close" data-dismiss="alert">x</button>
        @foreach($errors->all() as $error)
        <p>{{$error}}</p>
        @endforeach
    </div>
    @endif
        <div id="dash-side-right" class="alert alert-custom badge">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <p>Badge Earned!</p>
    </div>
    
    <!--
    <div id="activity" class="col-centered masthead tablecell-container" style="height:250px;">
       <div class="tint">
       <div id="recent_activity_container" class="col-centered col-md-5" style="margin:5px auto; display:block;">
       
        <div id="chart-container"></div>
        </div>

    </div> <!-- End of Tint 
    </div> -->
    
    @include('_partials.goal_header')
   
    <!-- Start of Recent Activity (middle column) -->
    <div class="row-centered" style="position:relative;">
        <ul class="recentActivity">
            @include('_partials.activityfeed')
        </ul>
    </div>
    
    
    <!-- Modal: Weight Loss Sign-up Form -->
<div class="modal fade" id="goalWeightModal" tabindex="-1" role="dialog" aria-labelledby="goalWeightModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     {{ Form::open(array('url' => 'goal/weight_registration')) }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="goalWeightModalLabel">Goal: Weight Loss</h4>
      </div>
      <div class="modal-body">
           <div class="row">
            <div class="col-md-6 col-sm-3 col-xs-4">
               <p>Choose the intensity tier</p>
                <div class="btn-group-xs intensity" data-toggle="buttons">
                    <label class="btn low">
                        {{Form::radio('intensity','1')}} <!-- 5 - 9 lbs -->
                        <span class="glyphicon glyphicon-fire" style="color:rgb(0, 255, 57)"></span>
                    </label>
                    <label class="btn moderate active">
                        {{Form::radio('intensity', '2', true)}} <!-- 10 - 19 lbs -->
                        <span class="glyphicon glyphicon-fire" style="color:orange"></span>
                    </label>
                    <label class="btn high">
                        {{Form::radio('intensity','3')}}  <!--20 - 26 lbs -->
                        <span class="glyphicon glyphicon-fire" style="color:red"></span>
                    </label>
                </div>
             </div>
             <div class="col-md-6">
                <div class="row">
                   <div class="col-md-12">
                       <span class="glyphicon glyphicon-fire" style="color:rgb(0, 255, 57)"></span><span>Tier 1: 5-9 lbs</span>
                   </div>
                   <div class="col-md-12">           
                        <span class="glyphicon glyphicon-fire" style="color:orange"></span><span>Tier 2: 10-19 lbs</span>
                    </div>  
                   <div class="col-md-12">    
                        <span class="glyphicon glyphicon-fire" style="color:red"></span><span>Tier 3: 20-26 lbs</span>
                   </div>
                </div>
             </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Deadline: 5/31/2015</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                   <label for="weight">Current Weight:</label>
                    <input id="weight" type="text" name="weight" placeholder="123.4 lbs" pattern="\d{2,3}(\.\d{1})?" required>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Not Now</button>
          {{Form::submit('Sign me up!', array('class'=> 'btn btn-primary'))}}
      </div>
      {{ Form::close()}}
    </div>
  </div>
</div>

    @include('_partials.modal-badge'));

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
{{ HTML::script('assets/js/d3.min.js') }}
{{ HTML::script('js/charts/chart.js')}} 
{{ HTML::script('assets/js/form/type.js')}}


<script type="text/javascript">
    activityChart();
    weightChart();
    
</script>

@stop