@extends('layouts.lite') @section('content')

<?php $today = new DateTime(); ?>
         

    
    
    @include('_partials.goal_header')
   
    <!-- Start of Recent Activity (middle column) -->
    <div class="row-centered" style="position:relative;">
        <ul class="recentActivity">
            @include('_partials.activityfeed')
        </ul>
    </div>
    
    
    @include('_partials.modal-badge')

@stop