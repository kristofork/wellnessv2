<?php

class GoalUser extends Eloquent
{
	protected $table = 'goals_users';

	public function goalUser()
	{
		return $this->belongsTo('User');
	}
}