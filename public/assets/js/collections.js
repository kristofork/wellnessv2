App.Collections.Users = Backbone.Collection.extend({
	model: App.Models.User,
	url: '/user',
	team: function (options){
		this.id = options.id;
		return "team!";

	},
	search: function ( opts ) {
		var result = this.where( opts );
		var resultCollection = new App.Collections.Users( result );

		return resultCollection;
	}
});

App.Collections.Teams = Backbone.Collection.extend({
	model: App.Models.Team,
	url: '/team'
});

App.Collections.TeamsUsers = Backbone.Collection.extend({
	initialize: function (models, options){
		this.id = options.id;
	},

	test: function(){
		return "test";
	},
	url: function() {
		return '/team/' + this.id
	} 
});