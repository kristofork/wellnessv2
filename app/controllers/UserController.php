<?php

class UserController extends BaseController
{

	public function getTeam()
	{
		$teamId = Input::get('teamId');
		echo $teamId;

	}

	public function index()
	{
		$data = DB::table('users')
			->join('teams', function($join)
			{
				$join->on('users.team_id', '=', 'teams.id');
			})
			->get();
			return Response::json($data);
		//return User::all();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::json();

        User::create(array(
        	'userfirst' => $input->firstname,
        	'userlast' => $input->lastname,
        	'team' => $input->teamnum,
        	'email' => $input->email
        	));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
	public function show($id)
	{
		return User::find($id);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
 		$user = User::find($id);
 		$input = Input::all();
 		//$user->firstname = $input->firstname;
 		//$user->lastname = $input->lastname;

 		//$user->teamNum = $input->team;
 		$user->active = $input['active'];
 		$user->admin = $input['admin'];

 		$user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return User::find($id)->delete();
    }	

    public function updatePassword()
    {
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'password' => 'confirmed|min:6');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('editprofile')
				->withErrors($validator);
		} else{
    	$user = Auth::user();
    	$user->password = Hash::make(Input::get('password'));
    	$user->save();
    	Session::flash('message', 'Password updated!');
    	return Redirect::to('editprofile');
    	}

    }

	// find user profile
	public function showProfile($id)
	{
        
        $currentHalf = currentHalfDate();
		$user = User::find($id);
		$team = Auth::user()->team_id;
		$currentuser = Auth::user()->id;
		$todaysDate = date('Y-m-d');
		$reward1 = Reward::find(1);
		$reward2 = Reward::find(2);
        $activities = Activity::with(array('user.badgeuser' => function($q){
                                    $q->join('badges','badges.id','=','badge_id')->orderBy('created_at','desc')->first();
        }),'user')->where('user_id', '=',$id)->orderBy('activities.created_at', 'desc')->take(10)->get();
        $userdata = User::with(array('goalprogress' => function($q) use($currentHalf){
            $q->whereBetween('created_at',array($currentHalf['start'], $currentHalf['end']))->with('goal');
        }))->where('id',$id)->first();
        $goaluser_count = GoalProgress::where('active', 1)->count();
        
        if(count($userdata->goalprogress) > 0){
        $goaldata=  $userdata->goalprogress->toArray()[0]; 
        //$hasGoal =count($userdata->goalprogress->toArray());
        $isGoalActive = ($goaldata['active']);
        $goaltype = $goaldata['goal']['type'];
        }else
        {
            $goaltype = null;
            $goaldata = null;
            $isGoalActive = false;
        }

		return View::make('profile.user')
			->with('title', 'Profile')
            ->with('userdata', $userdata)
            ->with('isGoalActive', $isGoalActive)
            ->with('goaltype', $goaltype)
			->with('teamname',Team::teamName())
			->with('userYearStats', Team::userYearStat($team))
			->with('user_time', $user->currentYearStats ? $user->currentYearStats->time : "0")		// User's time
			->with('hoursToReward', User::hoursToReward())
			->with('isAdmin',$user->isAdmin())
			->with('teamMembers', DB::table('users')
				->where('team_id', $team)
				->get(array('users.id','users.first_name','users.last_name','users.pic','users.userTotalHrs')))
			->with('fav_activities',Activity::favorites())
			->with('activities', $activities)
			->with('activity_likes',DB::table('activity_likes')
				->where('user_id',$currentuser)
				->get(array('activity_likes.user_id','activity_likes.act_id')))
			->with('rewards', Reward::current())
            ->with('goal_user_count', $goaluser_count);
	}


	// Edit user profile
	public function editMyProfile()
	{
		$user = Auth::user();
		$team = $user->team_id;
		return View::make('profile.edit')
		->with('teamname',Team::teamName())
		->with('userYearStats', Team::userYearStat($team))
		->with('title', 'Edit Profile')
		->with('isAdmin', $user->isAdmin())
		->with('teamMembers', DB::table('users')
			->where('team_id', $team)
			->get(array('users.id','users.first_name','users.last_name','users.pic')));
	}

	// Preview Picture
	public function preview_Picture_post()
	{
		// to prevent abuse of the system we generate a random hash and assign it to user's session
		// this way the same user cannot create many posters - only one allowed per session.
		if(!Session::has('hash')){
			$hash = str_random(8);
			Session::put('hash', $hash);
			File::makeDirectory('uploads/'.$hash);
		} else {
			$hash = Session::get('hash');
			if (!File::exists('uploads/'.$hash)) File::makeDirectory('uploads/'.$hash);
		}
		$newPath         = '/assets/img/users/avatars/';
		$userID          = Auth::user()->id;
		$fileExt         = "jpg";
		$newFileName     = $userID . '.' . $fileExt;
		$newFullPath     = $newPath. $userID . '.' . $fileExt; 
		$destinationPath = 'uploads/'.$hash;
		$filename        = Session::get('filename','original.jpg');
		$fullpath        = $destinationPath.'/'.$filename;


		// determine if the image should be cropped or not
		$cropped = false;
		if(Input::get('w') !='' && Input::get('w')!=0){
			$cropped = true;
			// crop the image
			Image::open($fullpath)
			->crop(Input::get('w'),Input::get('h'),Input::get('x'),Input::get('y'))
			->save($destinationPath.'/cropped.jpg');
			$filename = 'cropped.jpg';
			$fullpath = $destinationPath.'/'.$filename;
		}
		// Saves the path to the user account
		$user = User::find($userID);
		$user->pic = $newPath . $newFileName;
		$user->save();	
		$upload_success = File::move($fullpath, $newFullPath);	

		// Delete directory
		if (File::exists($destinationPath)){
			File::deleteDirectory($destinationPath);
		}
		
		if( $upload_success ) {
			Session::flash('message', 'Your picture was updated!');
		    return Response::json('success', 200);
			} else {
			return Response::json('error', 400);
			}
	}

	// process image upload
	public function postUpload()
	{

		$file = Input::file('file');
		 
		if(!Session::has('hash')){
			$hash = str_random(8);
			Session::put('hash', $hash);
		} else {
			$hash = Session::get('hash');
		}

		$destinationPath = 'uploads/'.$hash;
		$extension= $file->getClientOriginalExtension(); 
		$filename = 'original.'.$extension;

		Session::put('filename',$filename);

		$upload_success = Input::file('file')->move($destinationPath, $filename);
		 
		if( $upload_success ) {
			Image::open($destinationPath.'/'.$filename)->grab(50)->save($destinationPath.'/'.$filename);
			return Response::json(array('files'=>array('name'=>url($destinationPath.'/'.$filename.'?'.time()))), 200);
		} else {
		   return Response::json('error', 400);
		}
	}



	public function hourChart($id)
	{

		$currentYearDates = currentYearDate();
		$lastYearDates = lastYearDate();
		$oldStart =  $lastYearDates[0];
		$oldFinish = $lastYearDates[1];
		$currentStart = $currentYearDates[0];
		$currentFinish =  $currentYearDates[1];
        
		// Current Year
		$sql2 = "SELECT ROUND(SUM(TIME_TO_SEC(activity_time))/3600,2) as time, MONTH(activity_date) as month_number  FROM activities WHERE activity_date Between '$currentStart' AND '$currentFinish' AND user_id =". $id ."  AND type = 'time' GROUP BY MONTH(activity_date)ORDER BY (CASE 
          WHEN activity_date = MONTH(NOW())THEN 0 ELSE 1 END) ASC, activity_date ASC";		
		// Last Year
		$sql1 = "SELECT ROUND(SUM(TIME_TO_SEC(activity_time))/3600,2) as time, MONTH(activity_date) as month_number FROM activities WHERE activity_date between '$oldStart' AND '$oldFinish' AND user_id = ". $id ." AND type = 'time' GROUP BY MONTH(activity_date)ORDER BY (CASE 
          WHEN activity_date = MONTH(NOW())THEN 0 ELSE 1 END) ASC, activity_date ASC";
		
        
		$json = DB::select($sql2);
		$json1 = DB::select($sql1);
        
        if( count($json) && count($json1)) // if data is returned for both years
        {
        // Current Year
        for($x = 0; $x < count($json); $x++){
            $json[$x] = (object) array_merge( (array)$json[$x], array('name'=> 'Current'));
        }
        // Last Year
        for($x = 0; $x < count($json1); $x++){
            $json1[$x] = (object) array_merge( (array)$json1[$x], array('name'=> 'Last'));
        }    
        
		$json1 = json_encode($json1);
		$json1 = json_decode($json1);

		return Response::json(array($json1,$json));
        }
        elseif( ! count($json) && count($json1)) // if data is return for only last year
        {
        // Last Year
        for($x = 0; $x < count($json1); $x++){
            $json1[$x] = (object) array_merge( (array)$json1[$x], array('name'=> 'Last'));
        }
            return Response::json(array($json1));
        }
        else
        {
        // Current Year
        for($x = 0; $x < count($json); $x++){
            $json[$x] = (object) array_merge( (array)$json[$x], array('name'=> 'Current'));
        }
             return Response::json(array($json));   
        }
	}
    
    function weightchart($id)
    {
        $activity = GoalProgress::with(array('goalactivity' => function($query)
                                       {
                                           $query->orderBy('goal_date', 'desc');
                                       }
                                       ,'goal'))->where('user_id', $id)->where('active', 1)->get();
        $start_weight = $activity[0]->start;
        $goal = $activity[0]->goal->goal;
        $weight_goal = $start_weight - $goal;
        $deadline = $activity[0]->deadline;

        foreach($activity as $act)
        {
            $counter = (count($act->goalactivity));
            for($x = 0; $x < $counter; $x++)
                {
                    $new[$x] = (object) array_merge((array)$act->goalactivity[$x]->toArray(), array('goalline'=> $weight_goal));
                }     
        }
        
        return Response::json($new);
    }

	function hovercard($id)
	{
		$count = Activity::activityTotal($id);
		$user = User::find($id);
		$title = Level::find($user->rank_id)->name;
		$time = $user->userTotalHrs / 3600;
		$year = new DateTime($user->created_at);
		$year = $year->format('Y');
		$result = array('userFirst' => $user->first_name, 'userLast' => $user->last_name, 'pic' => $user->pic, 'created_at' => $user->created_at, 'activities' => $count, 'time' => $time, 'year' => $year, 'title' => $title);

		return Response::json($result);
	}
}