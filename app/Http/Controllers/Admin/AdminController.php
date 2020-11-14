<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ArticlesRepository;
use App\Repositories\PortfoliosRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Lavary\Menu\Menu;

class AdminController extends Controller
{
    /**
     * @var PortfoliosRepository
     */
    protected $p_rep;
    /**
     * @var ArticlesRepository
     */
    protected $a_rep;
    /**
     * @var User
     */
    protected $user;
    protected $template;
    protected $content = false;
    protected $title;
    protected $vars;


    public function __construct()
    {
        $this->user = Auth::user();

        if (!$this->user) {
            abort(403);
        }
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();

        $navigation = view(config('settings.theme') . '.admin.navigation')
            ->with('menu', $menu)
            ->render();

        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if ($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        $footer = view(config('settings.theme') . '.admin.footer')
            ->render();

        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)
            ->with($this->vars);
    }

    public function getMenu()
    {
        $menu = (new Menu)->make('admin_menu', function ($menu) {
            $menu->add('Статьи', ['route' => 'admin.articles.index']);
            $menu->add('Портфолио', ['route' => 'admin.articles.index']);
            $menu->add('Меню', ['route' => 'admin.menus.index']);
            $menu->add('Пользователи', ['route' => 'admin.users.index']);
            $menu->add('Привилегии', ['route' => 'admin.permissions.index']);
        });

        return $menu;
    }
}
