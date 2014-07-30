<?php

class RewardController extends BaseController
{

	// show reward
	public function show($id)
	{
		$reward = Reward::find($id);
		return Response::json($reward);
	}

}