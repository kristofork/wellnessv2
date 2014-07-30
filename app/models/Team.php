<?php

class Team extends Eloquent 
{
	protected $primaryKey = 'teamNum';
    public function user()
    {
        return $this->hasMany('User','teamNum');
    }
}
