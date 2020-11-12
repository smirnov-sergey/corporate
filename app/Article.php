<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App
 *
 * @property int id
 * @property string title
 * @property string text
 * @property string desc
 * @property string alias
 * @property string img
 * @property string created_at
 * @property string updated_at
 * @property int user_id
 * @property int category_id
 * @property string keywords
 * @property string meta_desc
 * @property User user
 * @property Category category
 * @property Comment comments
 */
class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'title', 'img', 'alias', 'text', 'desc', 'keywords', 'meta_desc', 'category_id'
    ];


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
