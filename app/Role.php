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
}
