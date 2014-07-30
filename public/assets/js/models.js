App.Models.User = Backbone.Model.extend({
	idAttribute: 'id',
	urlRoot: '/user'
});

App.Models.Team = Backbone.Model.extend({
	idAttribute: 'id',
	urlRoot: '/team'
});

App.Models.TeamsUsers = Backbone.Model.extend({
	idAttribute: 'id',
urlRoot: '/team'
});