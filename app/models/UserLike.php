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
    
    public static function likeTotal()
    {
        return DB::table('user_likes')
            ->sum('like_count');
    }

}