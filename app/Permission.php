<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package App
 *
 * @property int id
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property Role roles
 */
class Permission extends Model
{
    protected $table = 'permissions';


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permissions_role');
    }
}
