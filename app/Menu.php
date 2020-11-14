<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Menu
 * @package App
 *
 * @property int id
 * @property string title
 * @property string path
 * @property int parent
 * @property string created_at
 * @property string updated_at
 */
class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'title', 'path', 'parent'
    ];


    public function delete(array $options = [])
    {
        $child = self::where('parent', $this->id);
        $child->delete();

        return parent::delete();
    }
}
