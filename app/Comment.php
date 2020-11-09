<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App
 *
 * id int
 * text text
 * name string
 * email string
 * site string
 * parent_id int
 * created_at timestamp
 * updated_at timestamp
 * article_id int
 * user_id int
 */
class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['name', 'text', 'site', 'user_id', 'article_id', 'parent_id', 'email'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
