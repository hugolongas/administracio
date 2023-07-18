<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'soci_id'
    ];

    public function groups()
    {
        return $this
            ->belongsToMany(Group::class)
            ->withTimestamps();
    }
    public function promotors()
    {
        return $this
            ->belongsToMany(Promotor::class)
            ->withTimestamps();
    }
    public function soci()
    {
        return $this->hasOne(Soci::class, 'id', 'soci_id');
    }

    public function authorized($roles)
    {
        if ($this->checkRoles($roles)) {
            return true;
        }
        abort(401, 'Esta acción no está autorizada.');
    }

    public function checkRoles($roles)
    {
        if($this->isAdmin()) return true;
        
        if (is_array($roles)) {
            foreach ($this->groups as $group) {
                if ($group->hasAnyRole($roles))
                    return true;
            }
            foreach ($this->promotors as $promotor) {
                if ($promotor->hasAnyRole($roles))
                    return true;
            }
        } else {
            foreach ($this->groups as $group) {
                if ($group->hasRole($roles))
                    return true;
            }
            foreach ($this->promotors as $promotor) {
                if ($promotor->hasRole($roles))
                    return true;
            }
        }
        return false;
    }

    public function isAdmin()
    {
        foreach ($this->groups as $group) {
            if ($group->hasRole('admin'))
                return true;
        }
        return false;
    }
    public function isControl()
    {
        foreach ($this->groups as $group) {
            if ($group->hasRole('entrada'))
                return true;
        }
        return false;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}
