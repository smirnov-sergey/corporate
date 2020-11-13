<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App
 *
 * @property int id
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property User users
 * @property Permission permissions
 */
class Role extends Model
{
    protected $table = 'roles';


    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    /**
     * @param $name
     * @param false $require
     * @return bool|mixed
     */
    public function hasPermission($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $permission_name) {
                $has_permission = $this->hasPermissions($permission_name);

                if ($has_permission && !$require) {
                    return true;
                } elseif (!$has_permission && $require) {
                    return false;
                }

                return $require;
            }
        } else {
            foreach ($this->permissions as $permission) {
                if ($permission->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }
}
