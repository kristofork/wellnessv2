<?php

class Badge extends Eloquent {
	protected $fillable = [];

    protected $table = "ranks";
	public function user()
	{
		return $this->belongsTo('User');
	}

}