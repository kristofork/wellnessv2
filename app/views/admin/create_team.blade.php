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
    	<div class="active fluid-container" id="team">
	    	<h2>Create Team</h2>
			<!-- if there are creation errors, they will show here -->
			{{ HTML::ul($errors->all()) }}
	    	{{ Form::open(array('route' => array('admin_team.store'), 'method' => 'POST')) }}
			  <div class="form-group">
			    {{ Form::label('team_name', 'Team Name') }}
			    {{ Form::text('team_name', Input::old('team_name'), array('class' => 'form-control', 'placeholder' => 'Team Name')) }}
			  </div>
			  {{ Form::submit('Create Team', array('class' => 'btn btn-default'))}}
			{{ Form::close()}}
    	</div> <!-- End of User Tab-->
    </div> <!-- End of Middle Column-->

</div> <!-- End of Main-Row -->

@stop