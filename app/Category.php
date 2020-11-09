<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App
 *
 * id int
 * title string
 * parent_id int
 * alias string
 * created_at timestamp
 * updated_at timestamp
 */
class Category extends Model
{
    protected $table = 'categories';


    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
