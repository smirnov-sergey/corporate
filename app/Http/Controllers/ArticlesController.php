<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\ArticlesRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use App\Http\Requests;

class ArticlesController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep)
    {
        parent:: __construct(new MenusRepository(new Menu()));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
    }

    public function index()
    {
        $articles = $this->getArticles();

        return $this->renderOutput();
    }

    private function getArticles($alias = false)
    {
        $articles = $this->a_rep->get(['title', 'alias', 'created_at', 'img', 'desc'], false, true );

        if ($articles) {
//            $articles->load('user', 'category', 'comments');
        }

        return $articles;
    }
}
