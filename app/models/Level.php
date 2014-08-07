<?php

class Level extends Eloquent {
	protected $fillable = [];
	protected $table = "ranks";

	public function user()
	{
		return $this->belongsTo('User');
	}

}