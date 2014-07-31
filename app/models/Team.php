<?php

class Team extends Eloquent 
{
	protected $primaryKey = 'id';
    public function user()
    {
        return $this->hasMany('User','team_id');
    }

    public static function userYearStat($team)
    {
    	return $stat = DB::table('current_year_stats')
    		->where('current_year_stats.team_id', $team)
    		->join('users', 'users.id', '=', 'current_year_stats.user_id')
    		->get();
    }

    public static function teamName()
    {
    	return team::find(Auth::user()->team_id)->teamName;
    }

    public static function teamId()
    {
    	return team::find(Auth::user()->team_id)->id;
    }
}
