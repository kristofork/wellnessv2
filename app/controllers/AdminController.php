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

public function getAdminType($type)
{
    $items_per_page = Input::get('per_pg', 10);

    if ($type == 'user') {
        $items = User::orderBy('last_name', 'asc')->paginate($items_per_page);
        $view = View::make('admin.user_type')->with('items', $items);
    } else {
        $items = Team::orderBy('teamName','asc')->paginate($items_per_page);
        $view = View::make('admin.team_type')->with('items', $items);
    }

    
    echo $view;
    exit;
}

}