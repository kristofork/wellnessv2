//Global App View
App.Views.App = Backbone.View.extend({
	initialize: function() {
		var vent = _.extend({}, Backbone.Events);
		//var allUsersView = new App.Views.Users({ collection: teamsusers }).render();
		var allTeamsView = new App.Views.Teams({ collection: App.teams }).render();
		//var allTeamsUsersView = new App.Views.TeamsUsers({collection: App.teams});
		var teamMod = new App.Models.TeamsUsers({id: 5});
		teamMod.fetch();
		console.log(teamMod);
		$('.teamContainer').append(allTeamsView.el);
		        $('#inner-content-div').slimScroll({
		   			color: '#fff',	
			        height: '100%',
			        wheelStep: '1'
			    });
	}
});




App.Views.Users = Backbone.View.extend({
	el: ('#usersList'),

	initialize: function(){
	},
	render: function(){
		this.$el.html(""); // emptys the user view
		this.collection.each( this.addOne, this );
		return this;
	},

	addOne: function(user){
		var userView = new App.Views.User({model: user});
		this.$el.append(userView.render().el);
	}
});


// Single User View
App.Views.User = Backbone.View.extend({
	tagName: 'li',

	template: template('allUsersTemplate'),

	events: {
		"click button" : "editTeam"
	},
	editTeam: function(e){
		var team_id = e.target.id;
		var changeTeamView = new changeTeam({id : team_id, model: this.model});
	},
	initialize: function() {
		this.render();
	},

	render: function(){
		this.$el.html( this.template( this.model.toJSON() ));
		return this;
	}

});


App.Views.Teams = Backbone.View.extend({

	tagName: 'div',

	initialize: function(){

	},
	
	events: {
		"click a" : "teamsUserList"
	},
	teamsUserList: function(e){
            e.preventDefault();
            $('a').removeClass('active');
            $(e.target).addClass('active');
            var team_id = e.target.id;
            //var collection = new App.Collections.TeamsUsers([], {id: team_id});

            //collection.fetch().complete(function() {
            	var test = App.users.team({id: team_id});
            	console.log(test);
 			var userCol = App.users.search({teamNum: Number(team_id)});
 			console.log(userCol);
            	//var userCol = new App.Collections.Users(collection.toJSON() );
				var view= new App.Views.Users({collection: userCol}); 
				$('#usersList').append(view.render().el);
	//});

	}, 

	attributes: function() {
		return{
			class: 'span2 admin teams',
			id: 'inner-content-div'
		};
	},

	render: function(){
		this.collection.each( this.addOne, this );
		return this;
	},

	addOne: function(team){
		var teamView = new App.Views.Team({model: team});
		this.$el.append(teamView.render().el);
	}
});


// Single Team View
App.Views.Team = Backbone.View.extend({
	tagName: 'li',
	
	template: template('allTeamsTemplate'),

	attributes: function() {
		return{
			id: this.model.get('id')
		};
	},

	render: function(){
		this.$el.html( this.template( this.model.toJSON() ));
		return this;
	}

});


