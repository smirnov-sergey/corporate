<?php

namespace App\Http\Controllers;

use App\Repositories\MenusRepository;
use App\Repositories\SlidersRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Lavary\Menu\Menu;

class SiteController extends Controller
{
    protected $p_rep;
    /**
     * @var SlidersRepository
     */
    protected $s_rep;
    protected $a_rep;
    /**
     * @var MenusRepository
     */
    protected $m_rep;

    protected $template;
    protected $vars = [];

    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;
    protected $bar = FALSE;


    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        $menu = $this->getMenu();

        $navigation = view(env('THEME') . '.navigation')
            ->with('menu', $menu)
            ->render();

        $this->vars = array_add($this->vars, 'navigation', $navigation);

        return view($this->template)
            ->with($this->vars);
    }

    protected function getMenu()
    {
        $menu = $this->m_rep->get();

        $menu_builder = (new Menu)->make('MyNav', function ($m) use ($menu) {
            foreach ($menu as $item) {
                if ($item->parent == 0) {
                    $m->add($item->title, $item->path)
                        ->id($item->id);
                } else {
                    if ($m->find($item->parent)) {
                        $m->find($item->parent)
                            ->add($item->title, $item->path)
                            ->id($item->id);
                    }
                }
            }
        });

        return $menu_builder;
    }
}
