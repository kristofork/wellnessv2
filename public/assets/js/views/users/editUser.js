var changeTeam = Backbone.View.extend({
	el: ('#editUserModal'),
	template: template('team_select_template'),

	initialize: function() {
		this.render();

		this.form = this.$('#editUser');
		this.team = this.form.find('#edit_team');
		this.active = this.form.find('#edit_active');
		this.admin = this.form.find('#edit_admin'); 
	},
	events: {
		'click input#editUserBtn' : 'submit'
	},
	submit: function(e) {
		e.preventDefault();
		console.log(this.model);
		this.model.save({
			teamNum: this.team.val(),
			active: this.active.val(),
			admin: this.admin.val(),
		});
	},
	render: function(teams) {
		//var html = this.template(this.model.toJSON() );
		//$('#team_select_container').html(html);
		//this.$el.html(html);
		var team_select_temp = _.template($("#team_select_template").html(), {teams: App.teams, model: this.model.toJSON() });
		this.$el.html(team_select_temp);
		$('select#edit_team').val(this.id); // set team for user in select form
		$('input[name=admin]').click(function(){
		    if ($(this).is(':checked') ) {
		      $(this).val('1');
		    } else {
		      $(this).val('0');
		    }
		});
		$('input[name=active]').click(function(){
		    if ($(this).is(':checked') ) {
		      $(this).val('0');
		    } else {
		      $(this).val('1');
		    }
		});
		if($('#edit_active').val()== "0"){       
	         $("input#edit_active:checkbox").prop('checked',true);
	    }else{
	        $("input#edit_active:checkbox").prop('checked', false);
	    }
		if($('#edit_admin').val()== "1"){       
	         $("input#edit_admin:checkbox").prop('checked',true);
	    }else{
	        $("input#edit_admin:checkbox").prop('checked', false);
	    }

		return this;
	}
});