<?php

class LoginController extends BaseController {

	public function login()
	{
		$username = Input::get('username');
		$password = Input::get('password');

		$user = array('username' => $username,'password' => $password, 'active' => 1);

		if (Auth::attempt($user)) {
			return Redirect::route('log')
				->with('message', 'Welcome back!');
		}
		else
		{

			$user = User::where('username',$username)->where('active',1)->first();

			if( $user && $user->password == md5($password))
			{
				$user->password = Hash::make($password);
				$user->save();
				Auth::login($user);
				return Redirect::route('log')
					->with('message', "Welcome!");
			}
			else
		    {
				// authentication failure! Lets go back to the login page
				return Redirect::route('home')
				->with('flash_notice', 'Your username/password combination was incorrect.')
				->withInput();
			}
		}
	}

	public function logout()
	{
		Auth::Logout();

		return Redirect::route('home')
			->with('flash_notice', 'Come back soon!');
	}
}