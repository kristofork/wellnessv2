<?php

class Reward extends Eloquent
{
public static $tables = 'rewards';
public static $key = 'id';
protected $guarded = array('id');

	// Current reward period
	public static function current()
	{
		return $current = Reward::whereRaw('now() >= startdate and now() <= deadline')->get(); 
	}

	public static function rewardDeadline()
	{
		
	}


}