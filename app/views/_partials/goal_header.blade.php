    
<?php 

?>
   
   @if( count($userdata->goalprogress) && ! $isGoalActive) <!-- If Challenge for season complete, show only Time graph and other related data -->
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
    

    
      
       <!-- else show challenge graph data -->
       
      @else

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
@endif
@include('_partials.challengebar')