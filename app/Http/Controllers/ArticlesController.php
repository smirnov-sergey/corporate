<?php

namespace App\Http\Controllers;

use App\Category;
use App\Menu;
use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;

class ArticlesController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep)
    {
        parent:: __construct(new MenusRepository(new Menu()));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;

        $this->bar = 'right';
        $this->template = config('settings.theme') . '.articles';
    }

    public function index($cat_alias = false)
    {
        $this->title = 'Блог';
        $this->keywords = 'string';
        $this->meta_desc = 'string';

        $articles = $this->getArticles($cat_alias);

        $content = view(config('settings.theme') . '.articles_content')
            ->with('articles', $articles)
            ->render();

        $this->vars = array_add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->content_right_bar = view(config('settings.theme') . '.articles_bar')
            ->with([
                'comments' => $comments,
                'portfolios' => $portfolios
            ])
            ->render();

        return $this->renderOutput();
    }

    public function show($alias)
    {
        $article = $this->a_rep->one($alias, ['comments' => true]);

        if ($article) {
            $article->img = json_decode($article->img);
        }

        if (isset($article->id)) {
            $this->title = $article->title;
            $this->keywords = $article->keywords;
            $this->meta_desc = $article->meta_desc;
        }

        $content = view(config('settings.theme') . '.article_content')
            ->with('article', $article)
            ->render();

        $this->vars = array_add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->content_right_bar = view(config('settings.theme') . '.articles_bar')
            ->with([
                'comments' => $comments,
                'portfolios' => $portfolios
            ])
            ->render();

        return $this->renderOutput();
    }

    private function getArticles($alias = false)
    {
        $where = false;

        if ($alias) {
            $id = Category::select('id')
                ->where('alias', $alias)
                ->first()
                ->id;

            $where = ['category_id', $id];
        }

        $articles = $this->a_rep->get(
            ['id', 'title', 'alias', 'created_at', 'img', 'desc', 'user_id', 'category_id', 'keywords', 'meta_desc'],
            false,
            true,
            $where
        );

        if ($articles) {
            $articles->load('user', 'category', 'comments');
        }

        return $articles;
    }

    private function getComments($take)
    {
        $comments = $this->c_rep->get(['text', 'name', 'email', 'site', 'article_id', 'user_id'], $take);

        if ($comments) {
            $comments->load('article', 'user');
        }

        return $comments;
    }

    private function getPortfolios($take)
    {
        $portfolios = $this->p_rep->get(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], $take);

        return $portfolios;
    }
}
