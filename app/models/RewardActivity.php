<?php

class RewardActivity extends Eloquent
{
	protected $table = 'reward_activities';

public function users(){
  return $this->belongsTo('User', 'user_id');
}

}