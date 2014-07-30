<?php

class AdminController extends baseController
{
	public function index()
	{
		return View::make('admin.index');
	}
}