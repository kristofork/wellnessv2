<?php

class Goal extends Eloquent
{
	public function goal()
	{
		return $this->belongsTo('GoalUser');
	}
}