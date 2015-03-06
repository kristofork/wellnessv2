    <!-- Modal: Weight Loss Sign-up Form -->
<div class="modal fade" id="goalWeightModal" tabindex="-1" role="dialog" aria-labelledby="goalWeightModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     {{ Form::open(array('url' => 'goal/weight_registration')) }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="goalWeightModalLabel">Challenge: Weight Loss</h4>
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


    <!-- Modal: Run Distance Sign-up Form -->
    <div class="modal fade" id="goalRunDistanceModal" tabindex="-1" role="dialog" aria-labelledby="goalRunDistanceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     {{ Form::open(array('url' => 'goal/weight_registration')) }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="goalRunDistanceModalLabel">Challenge: Run Distance</h4>
      </div>
      <div class="modal-body">
           <div class="row">
            <div class="col-md-6 col-sm-3 col-xs-4">
               <p>Choose the intensity tier</p>
                <div class="btn-group-xs intensity" data-toggle="buttons">
                    <label class="btn low">
                        {{Form::radio('intensity','1')}} <!-- 5 - 9 lbs -->
                        <span class="glyphicons glyphicons-road" style="color:rgb(0, 255, 57)"></span>
                    </label>
                    <label class="btn moderate active">
                        {{Form::radio('intensity', '2', true)}} <!-- 10 - 19 lbs -->
                        <span class="glyphicons glyphicons-road" style="color:orange"></span>
                    </label>
                    <label class="btn high">
                        {{Form::radio('intensity','3')}}  <!--20 - 26 lbs -->
                        <span class="glyphicons glyphicons-road" style="color:red"></span>
                    </label>
                </div>
             </div>
             <div class="col-md-6">
                <div class="row">
                   <div class="col-md-12">
                       <span class="glyphicons glyphicons-road" style="color:rgb(0, 255, 57)"></span><span>Tier 1: 20 miles</span>
                   </div>
                   <div class="col-md-12">           
                        <span class="glyphicons glyphicons-road" style="color:orange"></span><span>Tier 2: 40 miles</span>
                    </div>  
                   <div class="col-md-12">    
                        <span class="glyphicons glyphicons-road" style="color:red"></span><span>Tier 3: 80 miles</span>
                   </div>
                </div>
             </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Deadline: 5/31/2015</p>
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


    <!-- Modal: Run Event Sign-up Form -->
    <div class="modal fade" id="goalRunEventModal" tabindex="-1" role="dialog" aria-labelledby="goalRunEventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     {{ Form::open(array('url' => 'goal/weight_registration')) }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="goalRunEventModalLabel">Challenge: Run Event</h4>
      </div>
      <div class="modal-body">
           <div class="row">
            <div class="col-md-6 col-sm-3 col-xs-4">
               <p>Choose the intensity tier</p>
                <div class="btn-group-xs intensity" data-toggle="buttons">
                    <label class="btn btn-sm">
                        {{Form::radio('intensity','1')}} <!-- 5k  -->
                        5k
                    </label>
                    <label class="btn btn-sm active">
                        {{Form::radio('intensity', '2', true)}} <!-- 10k -->
                        10k
                    </label>
                    <label class="btn btn-sm">
                        {{Form::radio('intensity','3')}}  <!-- half-marathon -->
                        13.1
                    </label>
                    <label class="btn btn-sm">
                        {{Form::radio('intensity','4')}}  <!-- full-marathon -->
                        26.2
                    </label>
                </div>
             </div>
             <div class="col-md-6">
                <div class="row">
                   <div class="col-md-12">
                       <span class="glyphicons glyphicons-person-running" style="color:rgb(0, 255, 57)"></span><span>5k: 3.1 miles</span>
                   </div>
                   <div class="col-md-12">           
                        <span class="glyphicons glyphicons-person-running" style="color:orange"></span><span>10k: 6.2 miles</span>
                    </div>  
                   <div class="col-md-12">    
                        <span class="glyphicons glyphicons-person-running" style="color:red"></span><span>13.1: Half Marathon</span>
                   </div>
                   <div class="col-md-12">    
                        <span class="glyphicons glyphicons-person-running" style="color:red"></span><span>26.2: Full Marathon</span>
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
                   <label for="">Optional</label>
                    {{Form::select('size', array('default' => 'Event Name', '1' => 'Boston', '2' => 'Philadelphia', '3' => 'New York City'), 'default')}}
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