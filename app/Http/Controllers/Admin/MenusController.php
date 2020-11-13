<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ArticlesRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Lavary\Menu\Menu;

class MenusController extends AdminController
{
    /**
     * @var MenusRepository
     */
    protected $m_rep;


    public function __construct(MenusRepository $m_rep, ArticlesRepository $a_rep, PortfoliosRepository $p_rep)
    {
        parent::__construct();

        if (Gate::allows('VIEW_ADMIN_MENU')) {
            abort(403);
        }

        $this->m_rep = $m_rep;
        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;

        $this->template = env('THEME') . '.admin.menus';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index()
    {
        $menu = $this->getMenus();

        $this->content = view(env('THEME') . '.admin.menus_content')
            ->with('menu', $menu)
            ->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getMenus()
    {
        $menu = $this->m_rep->get();

        if ($menu->isEmpty()) {
            return false;
        }

        return (new Menu)->make('for_menu_part', function ($m) use ($menu) {
            foreach ($menu as $item) {
                if ($item->parent === 0) {
                    $m->add($item->title, $item->path)
                        ->id($item->id);
                } else {
                    // поиск родительского пункта меню
                    if ($m->find($item->parent)) {
                        $m->find($item->parent)
                            ->add($item->title, $item->path)
                            ->id($item->id);
                    }
                }
            }
        });
    }
}
