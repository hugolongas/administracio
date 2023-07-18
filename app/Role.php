<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	public function groups()
	{
		return $this
		->belongsToMany(Group::class,'group_role')
		->withTimestamps();
	}
	public function promotors()
	{
		return $this
		->belongsToMany(Promotor::class,'promotor_role')
		->withTimestamps();
	}
}
