<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{    
    public function users()
    {
        return $this
            ->belongsToMany(User::class,'group_user')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this
            ->belongsToMany(Role::class,'group_role')
            ->withTimestamps();
    }

    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'Esta acción no está autorizada.');
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', 'admin')->first()) {
            return true;
        }
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
}
