<?php

class DashboardController extends BaseController
{
	public function index()
	{
		$numberOfTeamMembers = 0;
		$numberOfteamMembersReward = 0;
		$team = Auth::user()->team_id;
		$user = Auth::user()->id;
		$userData = Auth::user();
		$username = Auth::user()->username;
		$todaysDate = date('Y-m-d');
		$reward1 = Reward::find(1);
		$reward2 = Reward::find(2);
		$reward3 = Reward::find(3);
		$reward4 = Reward::find(4);
		$reward5 = Reward::find(5);

		return View::make('dashboard.index')
			->with('title', 'Dashboard')
			->with('teamname',Team::teamName())
			->with('hoursToReward', User::hoursToReward())
			->with('userYearStats', Team::userYearStat($team))
			->with('rewards', Reward::current())
			->with('activities', DB::table('activities')
				->join('users', 'users.id', '=', 'activities.user_id')
				->orderBy('activities.created_at', 'desc')
				->take(10)
				->get(array(DB::raw('users.id as `users_id`'), 'users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.activity_name', 'activities.likeCount','activities.type','activities.goal_num', 'users.pic', 'activities.created_at', 'activities.activity_time')))
			->with('activity_likes',DB::table('activity_likes')
				->where('user_id',$user)
				->get(array('activity_likes.user_id','activity_likes.act_id')))
			->with('teamMembers', DB::table('users')
				->where('team_id', $team)
				->get(array('users.id','users.first_name','users.last_name','users.pic','users.userTotalHrs')))
			->with('goals', DB::table('goals_users')
				->join('goals','goals.id','=', 'goals_users.goal_id')
				->where('user_id', $user)
				->get(array('goals.goal_name','goals.tier','goals.goal','goals_users.progress')))
			->with('rewards', DB::table('rewards')
				->where('startdate', '<=', $todaysDate)
				->where('deadline', '>=', $todaysDate)
				->get())
			->with(array('user' => $userData, 'reward1' => $reward1, 'reward2' => $reward2,'reward3' => $reward3, 'reward4' => $reward4, 'reward5' => $reward5));
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
		
		// Last Year
		//$sql1 = "SELECT ROUND(SUM(TIME_TO_SEC(actTime))/3600,2) as name FROM activities WHERE userName = 'wkkerns' AND type = 'time' AND actDate >= $lastYearDates[0] AND actDate <= $lastYearDates[1] GROUP BY MONTH(actDate)ORDER BY (CASE 
          //WHEN actDate = MONTH(NOW())THEN 0 ELSE 1 END) ASC, actDate ASC";
		

		$json = DB::select($sql);		
		$rows = array();
		foreach ($json as $row) {
		
		$rows[] = [$row->user, $row->yrTotal]; 

		}
		
		//$json = array_pluck($json, 'name');
		$json = json_encode($rows, JSON_NUMERIC_CHECK);
		$json = json_decode($json);



		return Response::json($json);
	}

}