<?php

namespace App\Repositories;

use App\Menu;
use Illuminate\Support\Facades\Gate;

class MenusRepository extends Repository
{
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    public function addMenu($request)
    {
        if (Gate::allows('save', $this->model)) {
            abort(403);
        }

        $data = $request->only('type', 'title', 'parent');

        switch ($data['type']) {
            case 'customLink':
                $data['path'] = $request->input('custom_link');
                break;
            case 'blockLink':
                if ($request->input('category_alias')) {
                    if ($request->input('category_alias') == 'parent') {
                        $data['path'] = route('articles.index');
                    } else {
                        $data['path'] = route('articles_cat', ['cat_alias' => $request->input('category_alias')]);
                    }
                } elseif ($request->input('article_alias')) {
                    $data['path'] = route('articles.show', ['alias' => $request->input('article_alias')]);
                }
                break;
            case 'portfolioLink':
                if ($request->input('filter_alias')) {
                    if ($request->input('filter_alias') == 'parent') {
                        $data['path'] = route('portfolios.index');
                    }
                } elseif ($request->input('portfolio_alias')) {
                    $data['path'] = route('portfolios.show', ['alias' => $request->input('portfolio_alias')]);
                }
                break;
        }

        unset($data['type']);

        if ($this->model->fill($data)->save()) {
            return ['status' => 'Ссылка добавлена'];
        }
    }

    public function updateMenu($request, $menu)
    {
        if (Gate::allows('update', $this->model)) {
            abort(403);
        }

        $data = $request->only('type', 'title', 'parent');

        if (empty($data)) {
            return ['error' => 'Данных нет'];
        }

        switch ($data['type']) {
            case 'customLink':
                $data['path'] = $request->input('custom_link');
                break;
            case 'blockLink':
                if ($request->input('category_alias')) {
                    if ($request->input('category_alias') == 'parent') {
                        $data['path'] = route('articles.index');
                    } else {
                        $data['path'] = route('articles_cat', ['cat_alias' => $request->input('category_alias')]);
                    }
                } elseif ($request->input('article_alias')) {
                    $data['path'] = route('articles.show', ['alias' => $request->input('article_alias')]);
                }
                break;
            case 'portfolioLink':
                if ($request->input('filter_alias')) {
                    if ($request->input('filter_alias') == 'parent') {
                        $data['path'] = route('portfolios.index');
                    }
                } elseif ($request->input('portfolio_alias')) {
                    $data['path'] = route('portfolios.show', ['alias' => $request->input('portfolio_alias')]);
                }
                break;
        }

        unset($data['type']);

        if ($menu->fill($data)->update()) {
            return ['status' => 'Ссылка обновлена'];
        }
    }

    public function deleteMenu($menu)
    {
        if (Gate::allows('delete', $this->model)) {
            abort(403);
        }

        if ($menu->delete()) {
            return ['status' => 'Ссылка удалена'];
        }
    }
}