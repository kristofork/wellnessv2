<!DOCTYPE html>
    <!--[if lt IE 10 ]> <html class="badIE"> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->
    <head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	        <title>
	            @section('title')
	            Fitness Force 2.1
	            @show
	        </title>
	        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	        <!--[if lt IE 10]>
	        {{ HTML::script('assets/js/jquery-1.9.1.min.js') }}
	        <![endif]-->
	        <!--[if (gt IE 9)|!(IE)]><!-->
	            {{ HTML::script('assets/js/jquery-2.0.2.js') }}
	        <!--<![endif]-->
	        
	        <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
	        <!-- CSS are placed here -->
	        {{ HTML::style('assets/css/bootstrap.css') }}
	        {{ HTML::style('assets/css/bootstrap-responsive.css') }}
	        {{ HTML::style('assets/css/styles.css') }}
	        {{ HTML::style('assets/css/spinner.css') }}
	        {{ HTML::style('assets/css/jquery.sidr.dark.css') }}
	        <link href='http://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
	        <link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
	        <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
	    <div id="background">
	        <img id="background-img" class="bg" src="../assets/img/site/bg/bg-01.jpg">
	    </div>

        <!-- Container -->
        <div class="container-fluid">

         <!-- Navbar -->
            <div class="navContainer" >
                <ul class="navCustom">
                <li id="profileLink">
                    <a class="navProfileLink" id="left-menu" href="#left-menu"></a>                    
                    <h5 class="linkText"></h5>
                </li>
                    <li class="{{ Request::is( 'blog') ? 'active' : '' }}"><a href="{{ URL::to('blog') }}"><img id="navImg" src="assets/img/site/newspaper.png"/></a></li>
                    <li class="{{ Request::is( 'dashboard') ? 'active' : '' }}"><a href="{{ URL::to('dashboard') }}"><img id="navImg" src="assets/img/site/dashboard.png"/></a></li>
                    <li class="{{ Request::is( 'profile') ? 'active' : '' }}"><a href="{{ URL::to('user') }}"><img id="navImg" src="assets/img/site/id-card.png"/></a></li>
                    <li class="{{ Request::is( 'goal') ? 'active' : '' }}"><a href="{{ URL::to('goals') }}"><img id="navImg" src="assets/img/site/test-tube.png"/></a></li>
                </ul>
            </div> <!-- End of Nav -->

	        <div class="row-fluid"> 
			<div class="modal hide fade" id="editUserModal"></div>
            <div class="teamContainer" id="demo"></div>
            <ul class="userContainer offset2" id="usersList"></ul>
            </div>
	    </div>
	</body>

        		<script type="text/template" id="allUsersTemplate">
        			<%= userFirst + " " + userLast %> <button type="button" id="<%= teamNum %>" data-toggle="modal" data-target="#editUserModal">Change Team</button>
        		</script>
        		<script type="text/template" id="allTeamsTemplate">
        			<a id='<%= teamNum %>' href='/team/<%= teamNum %>'><%= teamName %></a>
        		</script>
				<script type="text/template" id="team_select_template">
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h3>Edit User</h3>
			  </div>
  			  <div class="modal-body" id="team_select_container">
				<form id="editUser">
				<%= model.userFirst %> <%= model.userLast %>
				<div class="profilePicContainer">
				<img id="profilePic" src="<%= model.pic %>" />
				</div>
				<br />
				    <select name="team" id="edit_team">
				        <% teams.each(function(team) { %>
				            <option value="<%= team.get('teamNum') %>"><%= team.get('teamName') %></option>
				        <% }); %>
				    </select>
				    <br />

				    <input type="checkbox" name="active" id="edit_active" value="<%= model.active %>"> Account Disabled<br />
				    <input type="checkbox" name="admin" id="edit_admin" value="<%= model.admin %>">Admin<br />
				</div>
				<div id="editUserBtns" class="modal-footer">
				<a href="#" data-dismiss="modal" class="btn">Cancel</a><input type="submit" value="Save Changes" id="editUserBtn" class="btn btn-primary">
				</div>
				    </form>
				</script>

{{ HTML::script('assets/js/jquery-2.0.2.js')}}
{{ HTML::script('assets/js/bootstrap.min.js')}}
{{ HTML::script('assets/js/underscore.js')}}
{{ HTML::script('assets/js/backbone.js')}}
{{ HTML::script('assets/js/main.backbone.js')}}
{{ HTML::script('assets/js/models.js')}}
{{ HTML::script('assets/js/collections.js')}}
{{ HTML::script('assets/js/views.js')}}
{{ HTML::script('assets/js/views/users/editUser.js')}}
{{ HTML::script('assets/js/router.js')}}
{{ HTML::script('assets/js/jquery.slimscroll.min.js') }}




<script>
new App.Router;
Backbone.history.start();
//App.users = new App.Collections.Users;
App.teams = new App.Collections.Teams;
App.users = new App.Collections.Users;
//App.users.fetch().then(function() {
//	new App.Views.App({ collection: App.users });
//});
App.teams.fetch().then(function() {
	new App.Views.App({ collection: App.teams });
	App.users.fetch();
});
</script>
</html>