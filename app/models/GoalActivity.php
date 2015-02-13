<?php

class GoalActivity extends eloquent
{
    protected $table = "goals_activity";
    
    protected $fillable = array('user_id','goal_id','weight','goal_date', 'created_at','updated_at');
    
}