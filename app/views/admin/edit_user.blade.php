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
	    	<h2>Edit: {{$user->first_name}} {{$user->last_name}}</h2>
			<!-- if there are creation errors, they will show here -->
			{{ HTML::ul($errors->all()) }}
	    	{{ Form::model($user, array('route' => array('admin_user.update', $user->id), 'method' => 'PUT')) }}
			  <div class="form-group">
			    {{ Form::label('first_name', 'First Name') }}
			    {{ Form::text('first_name', null, array('class' => 'form-control')) }}
			  </div>
			  <div class="form-group">
			    {{ Form::label('last_name', 'Last Name') }}
			    {{ Form::text('last_name', null, array('class' => 'form-control')) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('email', 'Email') }}
			    <div class="input-group">
			      <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
			      {{ Form::email('email',null, array('class' => 'form-control'))}}
			    </div>
			  </div>
			  <div class="form-group">
			    {{ Form::label('active', 'Active') }}
			    {{ Form::checkbox('active', 1, array('class' => 'form-control')) }}
			  </div>
			  <div class="form-group">
			    {{ Form::label('admin', 'Admin') }}
			    {{ Form::checkbox('admin', 1, array('class' => 'form-control')) }}
			  </div>
			  	{{ Form::label('team', 'Teams')}}
				{{Form::select('team',array('Teams'=> $teams), $user->team_id, array('class' => 'form-control'))}}
				{{ Form::submit('Submit Changes', array('class' => 'btn btn-default'))}}
			{{ Form::close()}}
    	</div> <!-- End of User Tab-->
    </div> <!-- End of Middle Column-->

</div> <!-- End of Main-Row -->

@stop