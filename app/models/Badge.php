<?php

class Badge extends Eloquent {
	protected $fillable = [];

    protected $table = "badges";
	public function user()
	{
		return $this->belongsTo('User');
	}
    
     public function badgeuser()
    {
        return $this->hasMany('BadgeUser');
    }
    
    public function goal()
    {
        return $this->hasOne('Goal');
    }

}