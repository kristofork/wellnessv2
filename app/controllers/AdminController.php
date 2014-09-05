<?php

class AdminController extends baseController
{
	public function index()
	{
		$user = Auth::user();

		return View::make('admin.index')
		->with('title', 'Admin Panel')
		->with('isAdmin',$user->isAdmin())
		->with('allusers',User::orderBy('last_name', 'asc')->paginate(15))
		->with('allteams',Team::orderBy('teamName','asc')->paginate(10));
	}

	public function storeTeam()
	{
		// validate
		$rules = array(
			'team_name' => 'required|max:30|min:3'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/team/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$team = new Team;
			$team->teamName = Input::get('team_name');
			$team->save();

			$stat = new CurrentYearStatTeam;
			$stat->team_id = $team->id;
			$stat->save();

			// redirect
			Session::flash('message', 'Successfully created team!');
			return Redirect::to('admin');
		}
	}

	public function updateTeam($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'teamName' => 'required|max:30|min:3'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/team/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$team = Team::find($id);
			$team->teamName = Input::get('teamName');
			$team->save();

			// redirect
			Session::flash('message', 'Successfully updated team!');
			return Redirect::to('admin');
		}
	}

	public function createTeam()
	{
		$auth = Auth::user();
		return View::make('admin.create_team')
			->with('title', 'Create Team')
			->with('isAdmin',$auth->isAdmin());
	}

	public function editTeam($id)
	{
		$auth = Auth::user();
		$team = Team::find($id);

		return View::make('admin.edit_team')
		->with('title','Edit Team')
		->with('isAdmin',$auth->isAdmin())
		->with('team',$team);
	}
	public function destroyTeam($id)
	{
		$usercount = Team::find($id)->user->count();
		if($usercount == 0)
		{
			// delete
			$team = Team::find($id);
			$team->delete();

			// redirect
			Session::flash('message', 'Successfully deleted the team!');
			return Redirect::to('admin');
		}else{
			Session::flash('message', $usercount. ' Active user(s) still on team!');
			return Redirect::to('admin');
		}
	}

	public function editUser($id)
	{
		$auth = Auth::user();
		$user = User::find($id);
		$teams = Team::all()->lists('teamName','id');

		return View::make('admin.edit_user')
		->with('title','Edit User')
		->with('isAdmin',$auth->isAdmin())
		->with('user',$user)
		->with('teams',$teams);
	}

	public function storeUser()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'first_name' => 'required',
			'last_name'	 => 'required',
			'email'      => 'required|email',
			'team' => 'required|numeric'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$user = new User;
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->email      = Input::get('email');
			$user->username = strstr($user->email, '@', true); 
			$user->team_id = Input::get('team');
			$user->password = Hash::make('password1@');
			$user->save();

			$stat = new CurrentYearStat;
			$stat->user_id = $user->id;
			$stat->team_id = Input::get('team');
			$stat->save();

			$rank = new Rank;
			$rank->user_id = $user->id;
			$rank->username = $user->username;
			$rank->rank = 0;
			$rank->rankLw = 0;
			$rank->save();

			// redirect
			Session::flash('message', 'Successfully created user!');
			return Redirect::to('admin');
		}
	}

	public function createUser()
	{
		$teams = Team::all()->lists('teamName','id');
		$auth = Auth::user();
		return View::make('admin.create_user')
			->with('title', 'Create User')
			->with('isAdmin',$auth->isAdmin())
			->with('teams', $teams);
	}

	public function updateUser($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'first_name' => 'required',
			'last_name'	 =>	'required',
			'email'      => 'required|email',
			'team' 	 => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$user = User::find($id);
			$user->first_name       = Input::get('first_name');
			$user->last_name        = Input::get('last_name');
			$user->email      		= Input::get('email');
			$user->team_id 			= Input::get('team');
			$user->save();

			// redirect
			Session::flash('message', 'Successfully updated user!');
			return Redirect::to('admin');
		}
	}

	public function destroyUser($id)
	{
	// delete
		$user = User::find($id);
		$user->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the user!');
		return Redirect::to('admin');
	}


	public function resetPassword($id)
	{
		$string = str_random(8);
		$user = User::find($id);
		$user->password = Hash::make($string);
		$user->save();
		
		$email = $user->email;
		$name = $user->first_name;
		$data = array( 'email' => $email, 'name' => $name, 'password' => $string);
		Mail::send('emails.password_reset', $data, function($message) use($email, $name)
		{
		    $message->to($email, $name)->subject('Password Reset');
		});

		Session::flash('message', 'Password was changed!');
		return Redirect::to('admin');
	}

public function getAdminType($type)
{
    $items_per_page = Input::get('per_pg', 10);

    if ($type == 'user') {
        $items = User::orderBy('last_name', 'asc')->paginate($items_per_page);
        $view = View::make('admin.user_type')->with('items', $items);
    } elseif ($type == 'team') {
        $items = Team::orderBy('teamName','asc')->paginate($items_per_page);
        $view = View::make('admin.team_type')->with('items', $items);
    }else{
    	return User::showRewardUsers();
    }

    
    echo $view;
    exit;
}

public function getRewardUsers()
{
	return User::showRewardUsers();
}

}