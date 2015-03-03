<?php

class Rank extends Eloquent {
	protected $fillable = [];
	protected $table = "rankTbl";
    public $timestamps = false;
	protected $primaryKey  = 'rank';

	public function user()
	{
		return $this->belongsTo('User');
	}

}