<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Slider
 * @package App
 *
 * @property int id
 * @property string img
 * @property string desc
 * @property string title
 * @property string created_at
 * @property string updated_at
 */
class Slider extends Model
{
    protected $table = 'sliders';
}
