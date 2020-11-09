<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Filter
 * @package App
 *
 * id int
 * title string
 * alias string
 * created_at timestamp
 * updated_at timestamp
 */
class Filter extends Model
{
    protected $table = 'filters';
}
