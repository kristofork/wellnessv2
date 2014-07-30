<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getRememberToken()
	{
	return $this->remember_token;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    return 'remember_token';
	}
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    public function team()
    {
        return $this->hasOne('Team', 'teamNum');
    }

    public function goalUser()
    {
    	return $this->hasOne('GoalUser');
    }

    public function activities()
    {
        return $this->hasMany('Activity', 'userName');
    }

    public function badges()
    {
    	return $this->hasMany('Badge');
    }

    public static function hoursToReward()
    {
    	$reward = [];
    	$currents = Reward::current();
	    $today = strtotime(date('Y-m-d'));
		foreach ($currents as $current) {
    	$deadline = strtotime($current->deadline);
    	$milestone = $current->milestone;
    	$userTime = Auth::User()->userTotalHrs;
    	$result = ($milestone - $userTime) / floor(($deadline- $today) / (24 * 60 *60));
    	$result = round($result / 60 / 60,1);    	
    	$hrs = floor($result);
    	$mins = round(($result - $hrs) *60);
    	$reward[] =array('name' => $current->name, 'time' => intval($hrs). ":". intval($mins));
    }
    	return $reward;
    }


    public static $picRules = array(
    	'file' => 'required|mimes:jpeg|max:500',
    	);
    public static $picMessages = array(
    	'max'    => 'The :attribute must be under :max KB.',

    	);
    public static function validate($data){
    	return Validator::make($data, static::$picRules, static::$picMessages);
    }

}