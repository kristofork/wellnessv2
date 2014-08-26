@extends('layouts.admin')

@section('content')
<div class="main-row">
    <!-- Start of Sidebar Right -->
    <div id="dash-side-right" class="hidden-sm hidden-xs">

        <div class="sidebar-right">

            <h4 id="sidebar-heading">Stats</h4>
            <div class="sidebar-padding">


            </div>
                <div style="clear: both"></div> 
        </div>

    </div>
    <!-- End of Sidebar Right-->

    <!-- Start of Recent Activity (middle column) -->
    <div class="col-md-8 admin_edituser">
    	<div class="active fluid-container" id="user">
	    	<h2>Edit: {{$team->teamName}}</h2>
			<!-- if there are creation errors, they will show here -->
			{{ HTML::ul($errors->all()) }}
	    	{{ Form::model($team, array('route' => array('admin_team.update', $team->id), 'method' => 'PUT')) }}
			  <div class="form-group">
			    {{ Form::label('teamName', 'Team Name') }}
			    {{ Form::text('teamName', null, array('class' => 'form-control')) }}
			  </div>
				{{ Form::submit('Submit Changes', array('class' => 'btn btn-default'))}}
			{{ Form::close()}}
    	</div> <!-- End of User Tab-->
    </div> <!-- End of Middle Column-->

</div> <!-- End of Main-Row -->

@stop