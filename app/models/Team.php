<?php

class Team extends Eloquent 
{
	protected $primaryKey = 'id';
    public function user()
    {
        return $this->hasMany('User','team_id');
    }
}
