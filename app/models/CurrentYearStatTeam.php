<?php

class CurrentYearStatTeam extends Eloquent 
{
	
	protected $table = 'current_year_stats_team';

	public function team()
	{
		return $this->belongsTo('Team');
	}

}