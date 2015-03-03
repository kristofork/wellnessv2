@extends('layouts.lite') 

@section('content')

    @if(Session::has('message'))
    <div id="dash-side-right" class="alert alert-custom">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <p>{{Session::get('message') }}</p>
    </div>
    @endif

<div class="table-container" id="log-bg">
    <div class="tablecell-container">
        <div id="time-summary-container">
       <h1><span id="time_value"></span></h1>
        </div>
         <div class="logDataCol">
            <span id="day" title="Total amount of hours logged on for the current day selected">0:00</span>
            <span>day &#8226;</span>
            <span id="week" title="Total amount of hours logged on for the current week selected">0:00</span>
            <span>week</span>   
         </div>  
<form id="activity_form" name="activity_form" method="post">
                 <div id="logInputRow" class="row">
                    <div class="col-md-offset-1 col-md-8 col-sm-12 col-xs-12">
                            <input id="activity_text_input" name="activity_name" type="text" class="form-control" placeholder="Activity" />
                        </div>
                        <div id="timeSliderContainer" class="col-md-2 hidden-sm hidden-xs">
                            <div class="summary_item" style="text-align:center"><span class="glyphicon glyphicon-time"></span>
                            </div>
                        </div>
                        <div id="timeSliderContainer" class="col-md-offset-1 col-md-8 col-sm-12 col-xs-12">
                            <div id="time_slider2" class="custom-slide"></div>
                            <input id="time_val" type="hidden" name="activity_time" />
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12" style="margin-top:1em">
                            <button id="submitact" type="submit" class="btn btn-info btn-block">Submit</button>
                        </div>
                </div>
                <!-- End of Row -->
                 <div id="logDataRow" class="row-centered">
                     <div class="col-md-3 col-sm-3 col-xs-4 logDataCol">
                    <div class="progress" id="reward-progress">
                      <span class="tick">|</span>
                       @foreach($rewards as $reward)
                        <div class="bar progress-high" id="reward" title="Reward Progress" style="width: {{ percentageRound($reward->milestone, $user_time, 0); }}%">{{ percentageRound($reward->milestone, $user_time,0); }}%</div>
                        @endforeach
                    </div>
                    <div id="glyph-text">{{round($user_time / 60 / 60, 1)}} of {{$reward->milestone /60 / 60}} hours</div> 
                     </div>  
                     <div class="col-md-3 col-sm-3 col-xs-4 logDataCol">
                        <div class="summary_item"><input type="hidden" id="activity_datepicker" name="actdate" />
                            <span id="date_value" title="Date selected">Today</span>
                        </div>
                     </div>

                     <div class="col-md-3 col-sm-3 col-xs-4 logDataCol">
                        <div class="btn-group-xs intensity" data-toggle="buttons" title="Intensity of activity">
                            <label class="btn low">
                                <input type="radio" name="actintensity" id="intLow" value="1">
                                <span class="glyphicon glyphicon-fire" style="color:rgb(0, 255, 57)"></span>
                            </label>
                            <label class="btn moderate active">
                                <input type="radio" name="actintensity" id="intMod" value="2">
                                <span class="glyphicon glyphicon-fire" style="color:orange"></span>
                            </label>
                            <label class="btn high">
                                <input type="radio" name="actintensity" id="intHigh" value="3">
                                <span class="glyphicon glyphicon-fire" style="color:red"></span>
                            </label>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 hidden-xs logDataCol">
                        <div id="points" class="summary_item" title="Total amount of points for entered activity">Points:
                            <span id="points_value">2</span>
                        </div>
                     </div>
                        
                        <input id="points_hidden" size="2" name="factpt" type="hidden" />

                    
                </div>
                <!-- End of Row -->
            </form>
    </div>
 </div>  
           
@include('_partials.modal-badge')
    
@stop