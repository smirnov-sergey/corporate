<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use App\Http\Requests;

class PortfolioController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep)
    {
        parent:: __construct(new MenusRepository(new Menu()));

        $this->p_rep = $p_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.portfolios';
    }

    public function index()
    {
        $this->title = 'Портфолио';
        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';

        $portfolios = $this->getPortfolios();


        $content = view(env('THEME') . '.portfolios_content')
            ->with('portfolios', $portfolios)
            ->render();

        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    public function show($alias)
    {
        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);
        $portfolio = $this->p_rep->one($alias);

        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;

        $content = view(env('THEME') . '.portfolio_content')
            ->with([
                'portfolio' => $portfolio,
                'portfolios' => $portfolios,
            ])
            ->render();

        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    private function getPortfolios($take = false, $paginate = true)
    {
        $portfolios = $this->p_rep->get('*', $take, $paginate);

        if ($portfolios) {
            $portfolios->load('filter');
        }

        return $portfolios;
    }
}
