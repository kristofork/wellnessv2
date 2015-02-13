<?php

class GoalProgress extends Eloquent
{
	protected $table = 'goals_progress';
    
    public function goalactivity()
    {
        return $this->hasMany('GoalActivity', 'progress_id');
    }
    
    public function goal()
    {
        return $this->belongsTo('Goal');
    }
}