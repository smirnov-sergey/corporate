<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App
 *
 * id int
 * title string
 * text text
 * desc text
 * alias string
 * img string
 * created_at timestamp
 * updated_at timestamp
 * user_id int
 * category_id int
 * keywords string
 * meta_desc string
 */
class Article extends Model
{
    protected $table = 'articles';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
