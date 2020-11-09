<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Filter
 * @package App
 *
 * @property int id
 * @property string title
 * @property string alias
 * @property string created_at
 * @property string updated_at
 */
class Filter extends Model
{
    protected $table = 'filters';
}
