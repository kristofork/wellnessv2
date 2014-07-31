<?php

class GoalController extends BaseController
{
	public function index()
	{
		return View::make('goal.index');
	}

	public function update_progress()
	{
		$type = "goal";
		$user = User::find(Auth::user()->id);
		$username = Auth::user()->username;
		$goalweight = Input::get('progress');
		$id = $user->goalUser->id;
		$goal_id = $user->goalUser->goal_id;
		$currentProgress = $user->goalUser->progress;
		$total = $currentProgress + $goalweight;
		$goal = Goal::find($goal_id);
		$goalname = $goal->goal_name;
		$goalUser = GoalUser::find($id);
		$goalUser->progress = $total;
		$goalUser->save();

        Activity::create(array(
            'userName'=>$username,
            'actName'=> $goalname,
            'goal_num'=>$goalweight,
            'type'=>$type
        ));

		$result = array('success'=> true, 'message'=> 'Goal Updated','progress' => $total);

		return Response::json($result);
	}

	public function check()
	{
		$id = Auth::user()->id;
        $currentDateTime = convertTimeIso(date('Y-m-d H:i:s'));
        $goal = DB::select(DB::raw("SELECT * FROM  `activities` WHERE user_id = '$id' AND WEEK( created_at ) = WEEK('$currentDateTime') AND type = 'goal'"));
		$result = array('success'=> true, 'message'=> $goal);
		return Response::json($result);
	}
}