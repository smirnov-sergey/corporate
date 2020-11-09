<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Portfolio
 * @package App
 *
 * id int
 * title string
 * text text
 * customer string
 * alias string
 * img string
 * created_at timestamp
 * updated_at timestamp
 * filter_alias string
 * keywords string
 * meta_desc string
 */
class Portfolio extends Model
{
    protected $table = 'portfolios';

    public function filter()
    {
        return $this->belongsTo(Filter::class, 'filter_alias', 'alias');
    }
}
