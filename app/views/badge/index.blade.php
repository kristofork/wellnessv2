
@extends('layouts.lite') @section('content')
       
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
        <!-- Start of Recent Activity (middle column) -->
    <div class="row-centered" style="position:relative; padding: 0 15px;">
       
@foreach(array_chunk($badges->toArray(), 4) as $fourbadges)

    <div class="row">
        @foreach($fourbadges as $badge)
        
        

            @if(isset($badge))
             <?php $badgecount = count($badge['badgeuser']); // count
                   $date_earned = array_pluck($badge['badgeuser'],'created_at'); //only pull badge dates
                    $dates= array(); 
                    foreach($date_earned as $date) // format dates
                    {
                        $dates[] = date('m/y', strtotime($date));
                    }
            ?>
               <div class="col-md-3">
               <div class="badge_container">
                  @if($badgecount == 0) <!-- locked badge -->
                   <img class="badge-lineup" src="assets/img/badges/locked.svg" >
                   <h4 id="title">{{$badge['name']}}</h4>
                   <div id="desc">{{$badge['desc']}}</div>
                   
                   @else  <!-- unlocked badge -->
                   <span class="glyphicons glyphicons-circle-info" id="badge-info-button" data-placement="left" data-html="true" title="@foreach($dates as $date)<div><span id='golden-cup' class='glyphicons glyphicons-cup'></span> Earned on {{$date}} </div> @endforeach"></span>
                   
                   <img class="badge-lineup" src="assets/img/badges/{{$badge['image']}} " alt="">
                   <h4 id="title">{{$badge['name']}}</h4>
                   <div id="desc">{{$badge['desc']}}</div>                   
                   @endif
               </div>
               </div>
            @endif

        @endforeach
    </div>
@endforeach
    </div>
    
   @stop