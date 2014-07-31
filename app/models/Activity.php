<?php

class Activity extends Eloquent {
	public static $tables = 'activities';
protected $guarded = array('id');
	public function user()
	{
		return $this->belongsTo('User');
	}

	public function likes()
	{
		return $this->hasMany('ActivityLike','act_id');
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
        ->take(3)
        ->get(array('activities.activity_name'));
  }
}