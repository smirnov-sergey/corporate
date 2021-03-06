<?php

namespace App\Http\Controllers;

use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use App\Repositories\SlidersRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use Lavary\Menu\Menu;

class SiteController extends Controller
{
    /**
     * @var PortfoliosRepository
     */
    protected $p_rep;
    /**
     * @var SlidersRepository
     */
    protected $s_rep;
    /**
     * @var ArticlesRepository
     */
    protected $a_rep;
    /**
     * @var MenusRepository
     */
    protected $m_rep;
    /**
     * @var CommentsRepository
     */
    protected $c_rep;

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $template;
    protected $vars = [];

    protected $content_right_bar = FALSE;
    protected $content_left_bar = FALSE;
    protected $bar = 'no';


    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        $menu = $this->getMenu();

        $navigation = view(config('settings.theme') . '.navigation')
            ->with('menu', $menu)
            ->render();

        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if ($this->content_right_bar) {
            $right_bar = view(config('settings.theme') . '.right_bar')
                ->with('content_right_bar', $this->content_right_bar)
                ->render();

            $this->vars = array_add($this->vars, 'right_bar', $right_bar);
        }

        if ($this->content_left_bar) {
            $left_bar = view(config('settings.theme') . '.left_bar')
                ->with('content_left_bar', $this->content_left_bar)
                ->render();

            $this->vars = array_add($this->vars, 'left_bar', $left_bar);
        }

        $this->vars = array_add($this->vars, 'bar', $this->bar);

        $this->vars = array_add($this->vars, 'keywords', $this->keywords);
        $this->vars = array_add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = array_add($this->vars, 'title', $this->title);

        $footer = view(config('settings.theme') . '.footer')
            ->render();

        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)
            ->with($this->vars);
    }

    public function getMenu()
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
