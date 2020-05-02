<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function concurs()
    {
        $this->belongsTo(Concurs::class);
    }

    public function vots()
    {
        return $this->hasMany(Vot::class);
    }
}
