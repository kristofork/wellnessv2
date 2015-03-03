<?php

class Activity extends Eloquent {
    
	public static $tables = 'activities';

	public function user()
	{
		return $this->belongsTo('User','user_id');
	}
    
    public static function currentuserid()
    {
        return Auth::user()->id;
    }

	public function likes()
	{
		return $this->hasMany('ActivityLike','act_id');
	}
    
    public function badgeuser()
    {
        return $this->hasManyThrough('BadgeUser','Badge');
    }

    public static $rules = array(
   	  'actname' => 'required',
      'actdate' => 'required',
      'acttime' => 'required',
      'actintensity' => 'required',
      'factpt' => 'required'
    	);
    public static $messages = array(
       'actname.required' => 'Oops! You must select a activity.',
       'actdate.required' => 'Oops! You must select a date.',
       'acttime.required' => 'Uh oh! You forgot to set the time!',
       'actintensity.required' => 'Oh no! You did not set a intensity.',
       'factpt.required' => 'Something went wrong! Please contact your site administrator!',
    	);

    public static function validate($data) {
        return Validator::make($data, static::$rules, static::$messages);
    }

  public static function favorites()
  {
    return $favorites = DB::table('activities')
        ->join('users', 'activities.user_id', '=', 'users.id')
        ->where('users.id',Auth::user()->id)
        ->groupBy('activity_name')
        ->orderBy(DB::raw('COUNT(activities.activity_name)'), 'desc')
        ->take(1)
        ->get(array('activities.activity_name'));
  }

public static function activityTotalTypeTime()
{
    return Activity::where('type','time')->count();
}

  public static function activityTotal($id)
  {
    return $activity_total = Activity::where('user_id', $id)->count();
  }

  public static function activity_time_week($id)
  {
    $sql = "SELECT SUM(TIME_TO_SEC(COALESCE(a.activity_time,'00:00:00'))) AS TotalTime 
            FROM activities a
            WHERE a.user_id = $id
            AND YEARWEEK(a.activity_date)=YEARWEEK(CURRENT_DATE)";
    $result = DB::select($sql);
    return secondsToStringShort($result['0']->TotalTime);
  }
  public static function activity_time_lastweek($id)
  {
    $sql = "SELECT SUM(TIME_TO_SEC(COALESCE(a.activity_time,'00:00:00'))) AS TotalTime 
      FROM activities a 
      where a.user_id= $id
      AND YEARWEEK(a.activity_date)=YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
    $result = DB::select($sql);
    return secondsToStringShort($result['0']->TotalTime);
  }
}