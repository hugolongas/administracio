<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	public function sections()
	{
		return $this
		->belongsToMany(Section::class,'section_role')
		->withTimestamps();
	}
	public function promotors()
	{
		return $this
		->belongsToMany(Promotor::class,'promotor_role')
		->withTimestamps();
	}
}
