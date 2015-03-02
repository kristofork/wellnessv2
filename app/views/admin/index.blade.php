@extends('layouts.admin')

@section('content')

             @if(Session::has('message'))
                <div class="alert alert-custom">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <p>{{Session::get('message') }} </p>
                </div>
            @endif

<div class="main-row">
            <div class="col-md-8" id="dash-nav">
                <ul class="nav tabs" role="tablist">
                        <li class="active"><a href="#user" data-toggle="tab" data-target="#user, #user_stats, #user_search"><span class="hidden-xs">Users </span><span class="glyphicon glyphicon-user"></span> </a></li>
                        <li><a href="#team" data-toggle="tab" data-target="#team, #team_stats"><span class="hidden-xs">Teams </span><span class="glyphicon glyphicon-list-alt"></span> </a></li>
                        <li><a href="#reward" data-toggle="tab" data-target="#reward-tab, #reward_stats"><span class="hidden-xs">Rewards </span><span class="glyphicon glyphicon-gift"></span></a></li>
                        <li class="last"><a href="#settings" data-toggle="tab" class="disabled"><span class="hidden-xs">Settings </span><span class="glyphicon glyphicon-wrench"></span></a></li>
                </ul>
                <!-- Nav tabs -->
            </div>

    <!-- Start of Recent Activity (middle column) -->
    <div class="col-md-8 admin_usersCol tab-content">
    	<div class="tab-pane active fluid-container" id="user">
    		<a class="btn btn-default btn-xs" href="admin/create" role="button"><span class="glyphicon glyphicon-plus"></span></a>
	    	<ul id="users"></ul>

    	</div> <!-- End of User Tab-->
    	<div class="tab-pane fluid-container" id="team">
    		<a class="btn btn-default btn-xs" href="admin/team/create" role="button"><span class="glyphicon glyphicon-plus"></span></a>
	    	<ul id="teams"></ul>
    	</div> <!-- End of Team Tab-->
        <div class="tab-pane fluid-container" id="reward-tab">
            {{ Form::open(array('url' => 'admin/reward-filter', 'method' => 'GET')) }}
                <div class="btn-group pull-right reward-type" data-toggle="buttons">
                    <label class="btn btn-default btn-xs active">
                        <input type="radio" name="filter" value="Halfway Mark">&#189;
                    </label>
                    <label class="btn btn-default btn-xs">
                        <input type="radio" name="filter" value="Finish Line"><span class="glyphicon glyphicon-flag"></span>
                    </label>
                </div>
            {{ Form::close() }}
            <ul id="rewards"></ul>
        </div> <!-- End of Team Tab-->
    </div> <!-- End of Middle Column-->

    <!-- Start of Sidebar Right -->
    <div id="dash-side-right" class="hidden-sm hidden-xs tab-content">
       
        <div class="sidebar-right tab-pane active" id="user_search">
            <div id="sidebar-heading">User Search</div>
            <div class="sidebar-padding">
                <div class="row">
                    <div class="col-xs-12 col-md-12 admin_data_container">
                        <div class="row">
                            <input type="text" id="name_search" class="typeahead" type="text" placeholder="First or Last name" style="width:75%">
                        </div>
                    </div>
                </div>
            </div>
                <div style="clear: both"></div> 
        </div>
        
        <div class="sidebar-right tab-pane active" id="user_stats">
            <div id="sidebar-heading">User Stats</div>
            <div class="sidebar-padding">
                <div class="row">
                    <div class="col-xs-6 col-md-6 admin_data_container">
                        <div class="row">
                            <span>{{$userCount}}</span>
                            <h5>Active Users</h5>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 admin_data_container">
                        <div class="row">
                            <span>0.87</span>
                            <h5>On Pace</h5>
                        </div>
                    </div>
                </div>
            </div>
                <div style="clear: both"></div> 
        </div>
        
        <div class="sidebar-right tab-pane" id="team_stats">

            <div id="sidebar-heading">Team Stats</div>
            <div class="sidebar-padding">
                <div class="row">
                    <div class="col-xs-6 col-md-6 admin_data_container">
                        <div class="row">
                            <span>{{$teamCount - 1}}</span>
                            <h5>Team Count</h5>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 admin_data_container">
                        <div class="row">
                            <span>0.57</span>
                            <h5>Team Ratio</h5>
                        </div>
                    </div>
                </div>
            </div>
                <div style="clear: both"></div> 
        </div>
        <div class="sidebar-right tab-pane" id="reward_stats">

            <div id="sidebar-heading">Reward Stats</div>
            <div class="sidebar-padding">
                <div class="row">
                    <div class="col-xs-6 col-md-6 admin_data_container">
                        <div class="row">
                            <span>15</span>
                            <h5>Reward Count</h5>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 admin_data_container">
                        <div class="row">
                            <span>0.57</span>
                            <h5>Team Ratio</h5>
                        </div>
                    </div>
                </div>
            </div>
                <div style="clear: both"></div> 
        </div>

    </div>
    <!-- End of Sidebar Right-->

</div> <!-- End of Main-Row -->

{{HTML::script('js/admin/pagination.js')}}
{{HTML::script('assets/js/admin/vendor/handlebars-v1.3.0.js')}}
{{HTML::script('assets/js/admin/vendor/typeahead.bundle.min.js')}}
{{HTML::script('assets/js/admin/app.js')}}
{{HTML::script('assets/js/admin/autocomplete.js')}}
{{HTML::script('assets/js/admin/events.js')}}
{{HTML::script('assets/js/admin/init.js')}}

@stop