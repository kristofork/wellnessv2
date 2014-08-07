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

    public static function Rank($teamNumber)
    {
        // Excludes Individual group id 25
        $sql ="SELECT t.*, @row:=@row+1 rank
                from
                (SELECT t.id, t.teamName, ROUND(((SUM(u.userTotalHrs))/(COUNT(DISTINCT u.username))/3600),2) AS TeamAvg
                FROM users u
                LEFT JOIN teams t ON u.team_id = t.id
                WHERE t.id != 25
                GROUP BY u.team_id
                ) t
                join (SELECT @row:=0) pos
                ORDER BY t.TeamAvg DESC";
        $result = DB::select(DB::raw($sql));
        foreach ($result as $team ) {
            if($team->id == $teamNumber)
            {
                return $team->rank;
            }
        }
    }

    public static function Count()
    {
        // Count all teams minus 1 for the Individual group
        return Team::all()->count() -1;
    }
}
