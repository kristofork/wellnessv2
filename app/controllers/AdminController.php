<?php

class AdminController extends baseController
{
	public function index()
	{
		$user = Auth::user();

		return View::make('admin.index')
		->with('title', 'Admin Panel')
		->with('isAdmin',$user->isAdmin())
		->with('allusers',User::paginate(15));
	}
}