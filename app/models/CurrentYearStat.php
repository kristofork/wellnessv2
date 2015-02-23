<?php

class CurrentYearStat extends Eloquent 
{
	
	protected $table = 'current_year_stats';

	public function user()
	{
		return $this->belongsTo('User','user_id');
	}

}