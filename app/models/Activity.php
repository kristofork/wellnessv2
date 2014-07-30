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
}