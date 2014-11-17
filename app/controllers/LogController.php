<?php

class LogController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $user = Auth::user();
        $team = $user->team_id;
		return View::make('log.index')->with('title','Log')
            ->with('isAdmin', false)
            ->with('teamname',Team::teamName())
            ->with('userYearStats', Team::userYearStat($team));
	}
    
    
}