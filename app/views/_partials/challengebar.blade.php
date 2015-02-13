   <!-- Sign Up Bar -->
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
                @if(count($userdata->goalprogress) && ! $isGoalActive)
                <a href="#" class="trigger"><span id="rankCount" class="glyphicons glyphicons-person-running"></span></a>
                <div id="glyph-text" data-count="">
                Running
                </div>
                @else
                <a href="#" class="trigger"><span id="rankCount" class="glyphicons glyphicons-plus"></span></a>
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
       @if(count($userdata->goalprogress) && ! $isGoalActive)
        <span id="timeCount" class="glyphicons glyphicons-person-walking"></span>
        <div id="glyph-text">Walking</div>        
       @elseif(count($userdata->goalprogress) && $goaltype =="weight" && $isGoalActive)
        <span id="timeCount" class="glyphicons glyphicons-stopwatch"></span>
        <div id="glyph-text">{{deadlineCount( date("Y/m/d") ,$rewards[0]->deadline)}} days left</div> 
        
        @else
        <span id="timeCount" class="glyphicons glyphicons-stopwatch"></span>
        <div id="glyph-text">days left</div>         
        @endif
        
     </div>
     
     <div class="col-md-3 col-sm-3 col-xs-3 dashDataCol">
       @if(count($userdata->goalprogress) && ! $isGoalActive)
        <span id="timeCount" class="glyphicons glyphicons-dumbbell"></span>
        <div id="glyph-text">Gym</div>               
       @else
        <span id="teamrankCount" class="glyphicons glyphicons-group"></span>
        <div id="glyph-text"><span>{{$goal_user_count}} users taking challenge</span></div> 
        
        @endif
        
        
     </div>
    </div>
    