<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Slider
 * @package App
 *
 * id int
 * img string
 * desc text
 * title string
 * created_at timestamp
 * updated_at timestamp
 */
class Slider extends Model
{
    protected $table = 'sliders';
}
