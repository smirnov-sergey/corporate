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
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
