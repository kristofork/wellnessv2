    
<?php 
    $goaldata=  $userdata->goalprogress->toArray()[0]; // 
    $hasGoal =count($userdata->goalprogress->toArray());
    $isGoalActive = ($goaldata['active']);
    $goaltype = $goaldata['goal']['type'];
?>
   
   @if($hasGoal && ! $isGoalActive) <!-- If Challenge for season complete, show only Time graph and other related data -->
   <div class="row-centered table-container" style="position:relative; max-height:300px">
    <div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel">
       <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
           <div id="recent_activity_container" class="col-centered col-md-7" style="margin: 5px auto; display:block;">
               <div id="chart-container"></div>
            </div>
        </div>

        <div class="item">
            <div id="recent_activity_container" class="col-centered col-md-5" style="margin:5px auto; display:block;">
                <div id="chart-weight"></div>
            </div>
        </div>

        <div class="item">
          <img src="/assets/img/badges/weightloss-low.svg" alt="weightloss">
          <img class="badge-notification" src="/assets/img/badges/weightloss-low.svg" alt="weightloss">
        </div>

      </div>

    </div>
    
    </div>   <!-- end of table-container -->
    
@include('_partials.challengebar')
    
      
       <!-- else show challenge graph data -->
       
      @else
{{"if2"}}
        <div class="row-centered table-container" style="position:relative; max-height:300px">
    <div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel">
       <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
           <div id="recent_activity_container" class="col-centered col-md-7" style="margin: 5px auto; display:block;">
               <div id="chart-container"></div>
            </div>
        </div>

        <div class="item">
            <div id="recent_activity_container" class="col-centered col-md-5" style="margin:5px auto; display:block;">
                <div id="chart-weight"></div>
            </div>
        </div>

        <div class="item">
          <img src="/assets/img/badges/weightloss-low.svg" alt="weightloss">
          <img class="badge-notification" src="/assets/img/badges/weightloss-low.svg" alt="weightloss">
        </div>

      </div>

    </div>
    
    </div>   <!-- end of table-container -->
    
   <div id="dashDataRow" class="">
        <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
            <span id="likeCount" class="glyphicons glyphicons-scale"></span>
            <div class="weight" id="glyph-text" data-count="">
            @if(! count($userdata->goalprogress))
            <a data-toggle="modal" data-target="#goalWeightModal" href="#goalWeightModal">Click to set a goal</a>
            @else
            <span id="weight_data">{{$userdata->goalprogress[0]->progress}}</span> lbs lost
            @endif
            </div>  
        </div> 
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        
            <div class="popover-markup"> 
                <a href="#" class="trigger"><span id="rankCount" class="glyphicons glyphicons-plus"></span></a>
                @if(count($userdata->goalprogress))
                <div id="glyph-text"> <?php $daydiff =  $today->diff($userdata->goalprogress[0]->updated_at)->days; echo ($daydiff < 2) ?  $daydiff.' day ' : $daydiff.' days '; ?>since last weigh in </div>
                @endif
                {{ Form::open(array('url' => 'goal/store')) }}
                <div class="head hide">
                    <input type="hidden" id="weight_datepicker" name="date" />
                    <span id="date_value" title="Date selected">Today</span>
                </div>
                <div class="content hide">
                    <div class="form-group">
                        <input id="weight" type="text" name="weight" placeholder="123.4 lbs" pattern="\d{2,3}(\.\d{1})?" required />
                    </div>
                    <button id="weight_submit" type="submit" class="btn btn-default btn-block">
                        Submit
                    </button>
                </div>
                {{ Form::close()}}
            </div>
     </div>

     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        <span id="timeCount" class="glyphicons glyphicons-stopwatch"></span>
        <div id="glyph-text">{{deadlineCount( date("Y/m/d") ,$rewards[0]->deadline)}} days left</div> 
     </div>
     
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        <span id="teamrankCount" class="glyphicons glyphicons-group"></span>
        <div id="glyph-text">
            <span>{{$goal_user_count}} users taking challenge</span>
        </div> 
     </div>
    </div>
@endif