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
	// find user profile
	public function showProfile($id)
	{

		$user = User::find($id); 
		$team = Auth::user()->team_id;
		$currentuser = Auth::user()->id;
		$todaysDate = date('Y-m-d');
		$reward1 = Reward::find(1);
		$reward2 = Reward::find(2);
		$reward3 = Reward::find(3);
		$reward4 = Reward::find(4);
		$reward5 = Reward::find(5);
		return View::make('profile.user')
			->with('title', 'Profile')
			->with('teamname',Team::teamName())
			->with('userYearStats', Team::userYearStat($team))
			->with('teamMembers', DB::table('users')
				->where('team_id', $team)
				->get(array('users.id','users.first_name','users.last_name','users.pic','users.userTotalHrs')))
			->with('fav_activities',Activity::favorites())
			->with('activities', DB::table('activities')
				->join('users', 'users.id', '=', 'activities.user_id')
				->where('users.id', $user->id)
				->orderBy('activities.created_at', 'desc')
				->take(10)
				->get(array(DB::raw('users.id as `users_id`'), 'users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.activity_name', 'activities.likeCount','activities.type','activities.goal_num', 'users.pic', 'activities.created_at', 'activities.activity_time')))
			->with('activity_likes',DB::table('activity_likes')
				->where('user_id',$currentuser)
				->get(array('activity_likes.user_id','activity_likes.act_id')))
			->with('rewards', DB::table('rewards')
				->where('startdate', '<=', $todaysDate)
				->where('deadline', '>=', $todaysDate)
				->get())
			->with('rewards', Reward::current())
			->with(array('user' => $user, 'reward1' => $reward1, 'reward2' => $reward2,'reward3' => $reward3, 'reward4' => $reward4, 'reward5' => $reward5));
	}

	// show user's profile
	public function showMyProfile()
	{
		$user = Auth::user();
		$reward1 = Reward::find(1);
		$reward2 = Reward::find(2);
		$reward3 = Reward::find(3);
		$reward4 = Reward::find(4);
		$reward5 = Reward::find(5);
		return View::make('profile.user')
			->with('fav_activities', DB::table('activities')
				->join('users', 'activities.username', '=', 'users.username')
				->where('users.id',$user->id)
				->groupBy('activity_name')
				->orderBy(DB::raw('COUNT(activities.activity_name)'), 'desc')
				->take(1)
				->get(array('activities.activity_name')))
			->with('activities', DB::table('activities')
				->join('users', 'users.username', '=', 'activities.username')
				->where('users.id', $user->id)
				->orderBy('activities.created_at', 'desc')
				->take(5)
				->get(array('users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.actname', 'activities.likeCount', 'users.pic', 'activities.created_at', 'activities.activity_time')))
			->with('activity_likes',DB::table('activity_likes')
				->where('user_id',$user)
				->get(array('activity_likes.user_id','activity_likes.act_id')))
			->with(array('user' => $user, 'reward1' => $reward1, 'reward2' => $reward2,'reward3' => $reward3, 'reward4' => $reward4, 'reward5' => $reward5));

	}

	// Edit user profile
	public function editMyProfile()
	{
		$team = Auth::user()->teamNum;
		return View::make('profile.edit')
		->with('title', 'Edit Profile')
		->with('teamMembers', DB::table('users')
			->where('teamNum', $team)
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
		$newPath         = 'assets/img/users/avatars/';
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
			Session::flash('status_message', 'Your picture was updated!');
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
			Image::open($destinationPath.'/'.$filename)->grab(200)->save($destinationPath.'/'.$filename);
			return Response::json(array('files'=>array('name'=>url($destinationPath.'/'.$filename.'?'.time()))), 200);
		} else {
		   return Response::json('error', 400);
		}
	}



	public function hourChart()
	{

		$currentYearDates = currentYearDate();
		$lastYearDates = lastYearDate();
		$oldStart =  $lastYearDates[0];
		$oldFinish = $lastYearDates[1];
		$currentStart = $currentYearDates[0];
		$currentFinish =  $currentYearDates[1];

		// Current Year
		$sql = "SELECT ROUND(SUM(TIME_TO_SEC(activity_time))/3600,2) as name FROM activities WHERE activity_date Between '$currentStart' AND '$currentFinish' AND user_id = 190 AND type = 'time' GROUP BY MONTH(activity_date)ORDER BY (CASE 
          WHEN activity_date = MONTH(NOW())THEN 0 ELSE 1 END) ASC, activity_date ASC";
		
		// Last Year
		$sql1 = "SELECT ROUND(SUM(TIME_TO_SEC(activity_time))/3600,2) as name FROM activities WHERE activity_date between '$oldStart' AND '$oldFinish' AND user_id = 190 AND type = 'time' GROUP BY MONTH(activity_date)ORDER BY (CASE 
          WHEN activity_date = MONTH(NOW())THEN 0 ELSE 1 END) ASC, activity_date ASC";
		

		$json = DB::select($sql);
		$json = array_pluck($json, 'name');
		$json = json_encode($json, JSON_NUMERIC_CHECK);
		$json = json_decode($json);

		$json1 = DB::select($sql1);
		$json1 = array_pluck($json1, 'name');
		$json1 = json_encode($json1, JSON_NUMERIC_CHECK);
		$json1 = json_decode($json1);


		return Response::json(array(['name' => 'Current Year' ,'data' => $json], ['name' => 'Last Year' ,'data' => $json1]));
	}

	function hovercard($id){

		$sql = "SELECT Count(*) AS count FROM `activities` WHERE id = '190' AND type = 'time'";
		$count = DB::select($sql);
		$count = json_encode($count, JSON_NUMERIC_CHECK);
		$count= json_decode($count);
		$user = User::find($id);
		$result = array('userFirst' => $user->first_name, 'userLast' => $user->last_name, 'pic' => $user->pic, 'created_at' => $user->created_at, 'activities' => $count);

		return Response::json($result);

	}



}