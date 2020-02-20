<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activitat extends Model
{
    public function Socis()
    {
        return $this
            ->belongsToMany(Soci::class, 'activitat_soci')
            ->withTimestamps();
    }
}
