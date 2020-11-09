<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App
 *
 * @property int id
 * @property string title
 * @property int parent_id
 * @property string alias
 * @property string created_at
 * @property string updated_at
 * @property Article articles
 */
class Category extends Model
{
    protected $table = 'categories';


    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
