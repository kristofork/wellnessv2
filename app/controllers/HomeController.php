<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		return View::make('home');
	}

    public static function getMiniFeed()
    {
        $columns = array(DB::raw('users.id as `users_id`'), 'users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.activity_name', 'activities.likeCount','activities.type','activities.goal_num', 'users.pic', 'activities.created_at', 'activities.activity_time');
        $activities = DB::table('activities')
                ->join('users', 'users.id', '=', 'activities.user_id')
                ->orderBy('activities.created_at', 'desc')
                ->take(10)
                ->get($columns);
        $view = View::make('_partials.minifeed')->with('activities', $activities);
        echo $view;
        exit;
    }
    public static function getTopUsers()
    {
    	$users = User::orderBy('userTotalHrs','desc')->take(3)->get();

    	$view = View::make('_partials.topusers')->with('topusers', $users);
    	echo $view;
    	exit;
    }
}