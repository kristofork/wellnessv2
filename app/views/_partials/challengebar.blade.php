<!-- 3 stages of the bar
     1. Choosing a Challenge
     2. Active Challenege stats.
     3. Completed Challenge / Wait
       -->   
      <!-- Choosing a Challenge -->

      @if(! count($userdata->goalprogress))
       <div id="dashDataRow" class="">
        <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
            <span id="bar-col-1" class="glyphicons glyphicons-scale bar-columns"></span>
            <div class="weight" id="glyph-text" data-count="">

            <a data-toggle="modal" data-target="#goalWeightModal" href="#goalWeightModal">Click to start</a>

            </div>  
        </div> 
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
                <span id="bar-col-2" class="glyphicons glyphicons-person-running bar-columns"></span>
                <div class="" id="glyph-text" data-count="">
                <a href="#" id="run-popover">Click to start</a>
                </div>  
     </div>

     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">

        <span id="bar-col-3" class="glyphicons glyphicons-person-walking bar-columns"></span>
        <div id="glyph-text">Walking</div>        
        
     </div>
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        <span id="bar-col-4" class="glyphicons glyphicons-dumbbell bar-columns"></span>
        <div id="glyph-text">Gym</div>               
        
     </div>
    </div>
    
    @include('_partials.goal_signup')
    
    <script type="text/javascript">
        $(document).ready(function (){
            var runbuttons = '<div class="btn-group">';
                runbuttons+= '<button data-toggle="modal" data-target="#goalRunDistanceModal" href="#goalRunDistanceModal" type="button" class="btn btn-default"><span class="glyphicons glyphicons-map"></span></button>';
                runbuttons+= '<button data-toggle="modal" data-target="#goalRunEventModal" href="#goalRunEventModal" type="button" class="btn btn-default"><span class="glyphicons glyphicons-calendar"></span></button>';
                runbuttons+= '</div>';
  
            $("#run-popover").popover({
                html:true,
                placement: "bottom",
                trigger: "click",
                content: runbuttons
            });
        });
    </script>
    
@elseif(count($userdata->goalprogress) && $goaltype =="weight" && $isGoalActive)       
        <!-- Active Challenge Stats -->
       <div id="dashDataRow" class="">
        <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
            <span id="likeCount" class="glyphicons glyphicons-scale"></span>
            <div class="weight" id="glyph-text" data-count="">
            <span id="weight_data">{{$userdata->goalprogress[0]->progress}}</span> lbs lost
            </div>  
        </div> 
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        
            <div class="popover-markup">   

                <a href="#" class="trigger"><span id="rankCount" class="glyphicons glyphicons-plus"></span></a>
                <div id="glyph-text"> <?php $daydiff =  $today->diff($userdata->goalprogress[0]->updated_at)->days; echo ($daydiff < 2) ?  $daydiff.' day ' : $daydiff.' days '; ?>since last weigh in </div>

                {{ Form::open(array('url' => 'goal/store')) }}
                <div class="head hide">
                    <input type="hidden" id="weight_datepicker" name="date" />
                    <span id="date_value" title="Date selected">Today</span>
                </div>
                <div class="content hide">
                    <div class="form-group">
                        <input id="weight" type="text" name="weight" placeholder="123.4 lbs" autocomplete="off" pattern="\d{2,3}(\.\d{1})?" required />
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
        <div id="glyph-text"><span>{{$goal_user_count}} users taking challenge</span></div>     
        
     </div>
    </div>
    
@else
           <!-- Completed Challenge / Wait -->
       <div id="dashDataRow" class="">
        <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
            <span id="likeCount" class="glyphicons glyphicons-lock"></span>
            <div class="weight" id="glyph-text" data-count="">

            <span id="weight_data">{{$userdata->goalprogress[0]->progress}}</span> lbs lost
            </div>  
        </div> 
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
        
            <div class="popover-markup">   
                <span id="rankCount" class="glyphicons glyphicons-lock"></span>
                <div id="glyph-text" data-count="">
                Running
                </div>

            </div>
     </div>

     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">

        <span id="timeCount" class="glyphicons glyphicons-lock"></span>
        <div id="glyph-text">{{deadlineCount( date("Y/m/d") ,$rewards[0]->deadline)}} days left</div> 
        
        
     </div>
     
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">

        <span id="teamrankCount" class="glyphicons glyphicons-lock"></span>
        <div id="glyph-text"><span>{{$goal_user_count}} users taking challenge</span></div> 
        
     </div>
    </div>
@endif