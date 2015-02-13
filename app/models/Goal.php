<?php

class Goal extends Eloquent
{
	public function goal()
	{
		return $this->belongsTo('GoalUser');
	}
    
    public function badge()
    {
        return $this->hasOne('Badge');
    }
}