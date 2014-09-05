@extends('layouts.admin')

@section('content')

<div class="main-row">
            <div class="col-md-8" id="dash-nav">
                <ul class="nav tabs" role="tablist">
                        <li class="active"><a href="#user" data-toggle="tab"><span class="hidden-xs">Users </span><span class="glyphicon glyphicon-user"></span> </a></li>
                        <li><a href="#team" data-toggle="tab"><span class="hidden-xs">Teams </span><span class="glyphicon glyphicon-list-alt"></span> </a></li>
                        <li><a href="#reward" data-toggle="tab"><span class="hidden-xs">Rewards </span><span class="glyphicon glyphicon-gift"></span></a></li>
                        <li class="last"><a href="#settings" data-toggle="tab" class="disabled"><span class="hidden-xs">Settings </span><span class="glyphicon glyphicon-wrench"></span></a></li>
                </ul>
                <!-- Nav tabs -->
            </div>
             @if(Session::has('message'))
                <div class="alert alert-custom">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <p>{{Session::get('message') }} </p>
                </div>
            @endif

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
        <div class="tab-pane fluid-container" id="reward">
            <ul id="rewards"></ul>
        </div> <!-- End of Team Tab-->
    </div> <!-- End of Middle Column-->

    <!-- Start of Sidebar Right -->
    <div id="dash-side-right" class="hidden-sm hidden-xs">

        <div class="sidebar-right">

            <div id="sidebar-heading">User Stats</div>
            <div class="sidebar-padding">
                <div class="row">
                    <div class="col-xs-6 col-md-6 admin_data_container">
                        <div class="row">
                            <span>198</span>
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

    </div>
    <!-- End of Sidebar Right-->

</div> <!-- End of Main-Row -->

    <script>
 
$(function() {

    function getPaginationSelectedPage(url) {
        var chunks = url.split('?');
        var baseUrl = chunks[0];
        var querystr = chunks[1].split('&');
        var pg = 1;
        for (i in querystr) {
            var qs = querystr[i].split('=');
            if (qs[0] == 'page') {
                pg = qs[1];
                break;
            }
        }
        return pg;
    }

    $('#users').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var pg = getPaginationSelectedPage($(this).attr('href'));

        $.ajax({
            url: '/admin/ajax/user',
            data: { page: pg },
            success: function(data) {
                $('#users').html(data);
                $("html, body").animate({ scrollTop: 0 }, "fast");
            }
        });
    });

    $('#teams').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var pg = getPaginationSelectedPage($(this).attr('href'));

        $.ajax({
            url: '/admin/ajax/team',
            data: { page: pg },
            success: function(data) {
                $('#teams').html(data);
                $("html, body").animate({ scrollTop: 0 }, "fast");
            }
        });
    });

    $('#users').load('/admin/ajax/user?page=1');
    $('#teams').load('/admin/ajax/team?page=1');
    $('#rewards').load('/admin/ajax/reward');
});
 
    </script>

@stop