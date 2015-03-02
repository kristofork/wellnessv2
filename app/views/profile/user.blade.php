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



{{ HTML::script('assets/js/d3.min.js') }}

<script type="text/javascript">

    
</script>

@stop