<?php

class LoginController extends BaseController {

	public function login()
	{
		$user = array(
				'username' => Input::get('username'),
				'password' => Input::get('password')
				);

			if (Auth::attempt($user)) {
				return Redirect::route('dashboard')
					->with('message', 'Welcome back!');
			}
			else
			// authentication failure! Lets go back to the login page
			return Redirect::route('home')
				->with('flash_notice', 'Your username/password combination was incorrect.')
				->withInput();
	}

	public function logout()
	{
		Auth::Logout();

		return Redirect::route('home')
			->with('flash_notice', 'You are successfully logged out.');
	}
}