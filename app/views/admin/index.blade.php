@extends('layouts.admin')

@section('content')

<div class="main-row">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8" id="dash-nav">
                <ul class="nav tabs">
                <li class="active"><a href="#user" data-toggle="tab"><span class="hidden-xs">Users </span><span class="glyphicon glyphicon-user"></span> </a></li>
                <li><a href="#team" data-toggle="tab"><span class="hidden-xs">Teams </span><span class="glyphicon glyphicon-list-alt"></span> </a></li>
                <li><a href="#settings" data-toggle="" class="disabled"><span class="hidden-xs">Settings </span><span class="glyphicon glyphicon-wrench"></span></a></li>
                <li><a href="#" data-toggle="" class="disabled"><span class="hidden-xs">Rewards </span><span class="glyphicon glyphicon-gift"></span></a></li>
                </ul>
                <!-- Nav tabs -->
            </div>
        </div>
    </div>

    <!-- Start of Sidebar Right -->
    <div id="dash-side-right" class="hidden-sm hidden-xs">

        <div class="sidebar-right">

            <h4 id="sidebar-heading">Actions</h4>
            <div class="sidebar-padding">


            </div>
                <div style="clear: both"></div> 
        </div>

    </div>
    <!-- End of Sidebar Right-->

    <!-- Start of Recent Activity (middle column) -->
    <div class="col-md-8 admin_usersCol">
    	<ul>
	    @foreach($allusers as $user)
	    	<li>
	    		{{$user->first_name}}
    			<button type="button" class="btn btn-danger pull-right">Delete <span class="glyphicon glyphicon-remove"></span></button>
				<button type="button" class="btn btn-default pull-right">Edit <span class="glyphicon glyphicon-cog"></span></button>
  				<button type="button" class="btn btn-info pull-right">View <span class="glyphicon glyphicon-eye-open"></span></button>
	    	</li>
	        
	    @endforeach
    	</ul>
    	<?php echo $allusers->links(); ?>
    </div> <!-- End of Middle Column-->

</div> <!-- End of Main-Row -->

@stop