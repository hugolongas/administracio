<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soci extends Model
{
    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function Activitats()
    {
        return $this
            ->belongsToMany(Activitat::class, 'activitat_soci')
            ->withTimestamps();
    }
}
