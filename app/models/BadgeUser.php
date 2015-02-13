<?php

class BadgeUser extends Eloquent
{
	protected $table = 'badge_user';
    
    public function badge()
        {
            return $this->belongsTo('Badge');
        }
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    

}