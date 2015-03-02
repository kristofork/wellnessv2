   
   @if( count($userdata->goalprogress) && ! $isGoalActive) <!-- If Challenge for season complete, show only Time graph and other related data -->
   <div class="row-centered table-container" style="position:relative; max-height:300px">
    <div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel">
       <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
           <div id="recent_activity_container" class="col-centered col-md-7" style="margin: 5px auto; display:block;">
               <div id="chart-container"></div>
            </div>
        </div>

        <div class="item">
            <div id="recent_activity_container" class="col-centered col-md-7" style="margin:5px auto; display:block;">
                <h2>Congratulations</h2>
                <p>You completed a challenge for this season! More challenges await you.</p>
            </div>
        </div>


      </div>

    </div>
    
    </div>   <!-- end of table-container -->
    
      

      @elseif( count($userdata->goalprogress) && $isGoalActive)
   <div class="row-centered table-container" style="position:relative; max-height:300px">
    <div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel">
       <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
           <div id="recent_activity_container" class="col-centered col-md-7" style="margin: 5px auto; display:block;">
               <div id="chart-container"></div>
            </div>
        </div>

        <div class="item">
            <div id="recent_activity_container" class="col-centered col-md-7" style="margin:5px auto; display:block;">
                <div id="chart-weight"></div>
            </div>
        </div>


      </div>

    </div>
    
    </div>   <!-- end of table-container -->      
                  
       <!-- else show challenge graph data -->
       
      @else

        <div class="row-centered table-container" style="position:relative; max-height:300px">
    <div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel">
       <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0"></li>
        <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item">
           <div id="recent_activity_container" class="col-centered col-md-7" style="margin: 5px auto; display:block;">
               <div id="chart-container"></div>
            </div>
        </div>

        <div class="item active">
            <div id="recent_activity_container" class="col-centered col-md-7" style="margin:5px auto;width: 100%; max-height:350px; display:block; background-image: url('/img/goal-header.jpg')">
               <div class="slide-wrapper">
                   <div class="slide">
                   <div class="row">

                        <h2 style="margin-top: 4%;" class=" col-md-offset-5 col-md-7 col-lg-6">Do you have what it takes?</h2>

                        <h4 class="col-md-offset-6 col-md-6 col-lg-offset-8 col-lg-4">Start a challenge below.</h4>  
                       </div> 
                   </div>

               </div>
            </div>
        </div>


      </div>

    </div>
    
    </div>   <!-- end of table-container -->
@endif
@include('_partials.challengebar')