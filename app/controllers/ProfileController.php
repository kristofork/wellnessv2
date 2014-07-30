<?php

class ProfileController extends baseController
{
	public function index()
	{
		return View::make('profile.user');
	}

}