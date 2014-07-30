<?php

class ActivityLike extends Eloquent
{
	public static $tables = 'activity_likes';

	protected $fillable = array('act_id', 'user_id');

	public function activity()
	{
		return $this->belongsTo('Activity');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}