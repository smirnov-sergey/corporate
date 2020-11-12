<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Config;

abstract class Repository
{
    protected $model = false;

    public function get($select = '*', $take = false, $pagination = false, $where = false)
    {
        $builder = $this->model->select($select);

        if ($take) {
            $builder->take($take);
        }

        if ($where) {
            $builder->where($where[0], $where[1]);
        }

        if ($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    public function one($alias = false, $attr = [])
    {
        $result = $this->model->where('alias', $alias)->first();

        return $result;
    }

    /**
     * @param $result
     * @return false
     */
    protected function check($result)
    {
        if ($result->isEmpty()) {
            return false;
        }

        $result->transform(function ($item, $key) {
            if (is_string($item->img)
                && is_object(json_decode($item->img))
                && (json_last_error() == JSON_ERROR_NONE)
            ) {
                $item->img = json_decode($item->img);
            }

            return $item;
        });

        return $result;
    }

    public function transliterate($string)
    {
        $str = mb_strtolower($string, 'UTF-8');

        $liter_array = [
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ё" => "yo",
            "ж" => "zh",
            "з" => "z",
            "и" => "i",
            "й" => "j",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "kh",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "sch",
            "ъ" => "",
            "ы" => "y",
            "ь" => "",
            "э" => "e",
            "ю" => "yu",
            "я" => "ya",
        ];

        foreach ($liter_array as $liter => $kyr) {
            $str = str_replace($kyr, $liter, $str);
        }

        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);

        $str = trim($str, '-');

        return $str;
    }
}