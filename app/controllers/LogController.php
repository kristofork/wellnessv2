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
        $pointDifference           = User::rankPointDiff();
		$reward1                   = Reward::find(1);
		$reward2                   = Reward::find(2);
		return View::make('log.index')->with('title','Log')
            ->with('isAdmin', false)
            ->with('rewards', Reward::current())
            ->with('teamname',Team::teamName())
            ->with('userYearStats', Team::userYearStat($team))
            ->with('point_difference', $pointDifference)        // Point difference
            ->with('user_time', $user->currentYearStats ? $user->currentYearStats->time : "0")		// User's time
            ->with(array('reward1' => $reward1, 'reward2' => $reward2));
	}
    
    
}