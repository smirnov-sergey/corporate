<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App
 *
 * @property int id
 * @property string text
 * @property string name
 * @property string email
 * @property string site
 * @property int parent_id
 * @property string created_at
 * @property string updated_at
 * @property int article_id
 * @property int user_id
 * @property Article article
 * @property User user
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
