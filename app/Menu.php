<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Menu
 * @package App
 *
 * id int
 * title string
 * path string
 * parent int
 * created_at timestamp
 * updated_at timestamp
 */
class Menu extends Model
{
    protected $table = 'menus';
}
