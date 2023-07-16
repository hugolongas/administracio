<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vot extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
