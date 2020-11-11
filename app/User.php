<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string remember_token
 * @property string created_at
 * @property string updated_at
 * @property string login
 * @property Article articles
 * @property Role roles
 */
class User extends Authenticatable
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }


    /**
     * @param $permission 'string' or array('VIEW_ADMIN, 'ADD_ARTICLES')
     * @param false $require
     * @return bool|mixed
     */
    public function canDo($permission, $require = false)
    {
        if (is_array($permission)) {
            foreach ($permission as $permission_name) {
                $permission_name = $this->canDo($permission_name);

                if ($permission_name && !$require) {
                    return true;
                } elseif (!$permission_name && $require) {
                    return false;
                }

                return $require;
            }
        } else {
            foreach ($this->roles as $role) {
                foreach ($role->permissions as $permission) {
                    if (str_is($permission, $permission->name)) {
                        return true;
                    }
                }
            }
        }
    }

    /**
     * @param $name
     * @param false $require
     * @return bool|mixed
     */
    public function hasRole($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $role_name) {
                $has_role = $this->hasRole($role_name);

                if ($has_role && !$require) {
                    return true;
                } elseif (!$has_role && $require) {
                    return false;
                }

                return $require;
            }
        } else {
            foreach ($this->roles as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }
}
