<?php

class UserLike extends Eloquent
{
	public static $tables = 'user_likes';
    protected $primaryKey = 'user_id';

	protected $fillable = array('user_id', 'like_count');

	public function user()
	{
		return $this->belongsTo('User','user_id');
	}

}