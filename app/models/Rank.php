<?php

class Rank extends Eloquent {
	protected $fillable = [];
	protected $table = "rankTbl";
	protected $primaryKey  = 'rank';

	public function user()
	{
		return $this->belongsTo('User');
	}

}