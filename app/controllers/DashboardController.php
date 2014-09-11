<?php

class DashboardController extends BaseController
{
	public function index()
	{
		$numberOfTeamMembers = 0;
		$numberOfteamMembersReward = 0;
		$user = Auth::user();
		$team = $user->team_id;
		$user_id = $user->id;
		$points = $user->userTotalPts;
		$userData = $user;
		$username = $user->username;
		$user_rank = $user->rank_id;
		$todaysDate = date('Y-m-d');
		$reward1 = Reward::find(1);
		$reward2 = Reward::find(2);
		$year = new DateTime($user->created_at);
		$year = $year->format('Y');
		$columns = array(DB::raw('users.id as `users_id`'), 'users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.activity_name', 'activities.likeCount','activities.type','activities.goal_num', 'users.pic', 'activities.created_at', 'activities.activity_time');
		return View::make('dashboard.index')
			->with('title', 'Dashboard') // Page title
			->with('name',array('first_name'=> $user->first_name, 'last_name'=> $user->last_name))
			->with('pic',$user->pic)
			->with('user_title', User::UserTitle()) 				// Rank title
			->with('user_points', $points)							// User's points
			->with('user_time', $user->currentYearStats ? $user->currentYearStats->time : "0")		// User's time
			->with('required_points',User::UserPoints($user_rank))	// Next Level Points
			->with('teamname',Team::teamName())						// Team Name
			->with('year', $year)									// Start Year
			->with('isAdmin', $user->isAdmin())
			->with('time_week', Activity::activity_time_week($user_id))
			->with('time_lastweek', Activity::activity_time_lastweek($user_id))
			->with('hoursToReward', User::hoursToReward())
			->with('userYearStats', Team::userYearStat($team))
			->with('user_rank',$user->ranks ? $user->ranks->rank : "0")
			->with('user_count',User::userCount())
			->with('team_rank',Team::Rank($team))
			->with('team_count',Team::Count())
			->with('rewards', Reward::current())
			->with('activities', DB::table('activities')
				->join('users', 'users.id', '=', 'activities.user_id')
				->orderBy('activities.created_at', 'desc')
				->take(10)
				->get($columns))
			->with('activity_likes',DB::table('activity_likes')
				->where('user_id',$user_id)
				->get(array('activity_likes.user_id','activity_likes.act_id')))
			->with('teamMembers', DB::table('users')
				->where('team_id', $team)
				->get(array('users.id','users.first_name','users.last_name','users.pic','users.userTotalHrs')))
			->with('goals', DB::table('goals_users')
				->join('goals','goals.id','=', 'goals_users.goal_id')
				->where('user_id', $user_id)
				->get(array('goals.goal_name','goals.tier','goals.goal','goals_users.progress')))
			->with('rewards', DB::table('rewards')
				->where('startdate', '<=', $todaysDate)
				->where('deadline', '>=', $todaysDate)
				->get())
			->with(array('user' => $userData, 'reward1' => $reward1, 'reward2' => $reward2));
	}

	public function teamMembers(){
		return Auth::user()->team;
	}

	public function currentRewards(){
		Reward::current();
	}

	public function donutChart()
	{
		$team = Team::teamId();
		// Current Year
		$sql = "SELECT u.id AS id , u.first_name AS user, ROUND((c.time)/3600,2) AS yrTotal 
		FROM users u LEFT OUTER JOIN current_year_stats c ON c.user_id = u.id 
		WHERE c.team_id= $team GROUP BY id";

		$json = DB::select($sql);		
		$rows = array();
		foreach ($json as $row) 
		{
			$rows[] = [$row->user, $row->yrTotal]; 
		}
		
		$json = json_encode($rows, JSON_NUMERIC_CHECK);
		$json = json_decode($json);
		return Response::json($json);
	}

}