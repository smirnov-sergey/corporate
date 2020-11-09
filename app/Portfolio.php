<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Portfolio
 * @package App
 *
 * @property int id
 * @property string title
 * @property string text
 * @property string customer
 * @property string alias
 * @property string img
 * @property string created_at
 * @property string updated_at
 * @property string filter_alias
 * @property string keywords
 * @property string meta_desc
 * @property Filter filter
 */
class Portfolio extends Model
{
    protected $table = 'portfolios';

    public function filter()
    {
        return $this->belongsTo(Filter::class, 'filter_alias', 'alias');
    }
}
