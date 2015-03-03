<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

    protected $guarded = array('password');

    
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

  	/**
	 * Relationship Models
	 *
	 * 
	 */  
    
    public function team()
    {
        return $this->hasOne('Team', 'id');
    }

    public function goalUser()
    {
    	return $this->hasOne('GoalUser');
    }

    public function activities()
    {
        return $this->hasMany('Activity');
    }

    public function badge()
    {
    	return $this->hasManyThrough('Badge','BadgeUser','badge_id', 'id');
    }
    public function badgeuser()
    {
        return $this->hasMany('BadgeUser');
    }

    
     public function posts()
    {
        return $this->hasMany('Post');
    }

    public function ranks()
    {
    	return $this->hasOne('Rank');
    }
    public function currentYearStats()
    {
        return $this->hasOne('CurrentYearStat');
    }

    public function badgeprogress()
    {
        return $this->hasMany('BadgeProgress');
    }
    public function goalprogress()
    {
        return $this->hasMany('GoalProgress');
    }
    public function activitylikes()
    {
        return $this->hasMany('ActivityLike');
    }
    // Average per day to meet Reward
    public static function hoursToReward()
    {
    	$currents = Reward::current();
	    $today = strtotime(date('Y-m-d'));
		foreach ($currents as $current) {
    	$deadline = strtotime($current->deadline);
    	$milestone = $current->milestone;
    	$userTime = Auth::user()->currentYearStats ? Auth::user()->currentYearStats->time : "0";
    	$result = ($milestone - $userTime) / ($deadline- $today);
    	$result = round($result *24 * 60 * 60,1);    	
    	$hrs = floor($result / 3600);
        $totalmins = $result % 3600 ;
        $mins = ($totalmins == '0.0') ? $mins = '00' : round(($totalmins) /60);
        $str = '';
        if($mins < 10 ){
            $str .= "0";
            $str .= $mins;
            $mins = $str;
        }
    	$reward =array('name' => $current->name, 'time' => intval($hrs). ":". $mins);
    }
    	return $reward;
    }

    public static function UserTitle()
    {
    	$user = Auth::user()->rank_id;
    	$rank = Level::find($user);
    	return $rank->name;
    }
    public static function rankPointDiff()
    {
        $user = Auth::user()->rank_id;
        if ($user == 1) {
            return 0;
        } else
        {
        $rank = Level::find($user - 1);
    	return $rank->required;
        }
    }

    public static function UserPoints($id)
    {
    	$points_required = DB::table('ranks')->select('required')
         ->where('id', $id )
         ->first();
         return $points_required->required;
    }

    public static function activeUsers()
    {
        return User::where('active','1')->get()->count();
    }
    public static function userCount()
    {
        return User::all()->count();
    }

    public static function userLikeCount($id)
    {
        $q = UserLike::find($id);
        
        return $q ? $q->like_count : "0";
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

    public function isAdmin()
    {
       return $this->role === "admin";
    }




}