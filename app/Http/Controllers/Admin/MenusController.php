<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Filter;
use App\Http\Requests\MenusRequest;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Throwable
     */
    public function create()
    {
        $this->title = 'Новый пункт меню';

        $tmp_menus = $this->getMenus()->roots();
        // уменьшить коллекцию на 1 элемент при каждом вызове функции
        $menus = $tmp_menus->reduce(function ($return_menus, $menu) {
            $return_menus[$menu->id] = $menu->title;

            return $return_menus;
        }, ['0' => 'Родительский пункт меню']);

        $tmp_articles = $this->a_rep->get(['id', 'title', 'alias']);
        $articles = $tmp_articles->reduce(function ($return_articles, $article) {
            $return_articles[$article->alias] = $article->title;

            return $return_articles;
        }, []);

        $tmp_filters = Filter::select(['id', 'title', 'alias'])->get();
        $filters = $tmp_filters->reduce(function ($return_filters, $filter) {
            $return_filters[$filter->alias] = $filter->title;

            return $return_filters;
        }, ['parent' => 'Раздел портфолио']);

        $tmp_portfolios = $this->p_rep->get(['id', 'alias', 'title']);
        $portfolios = $tmp_portfolios->reduce(function ($return_portfolios, $portfolio) {
            $return_portfolios[$portfolio->alias] = $portfolio->title;

            return $return_portfolios;
        }, []);

        $list = [];
        $list = array_add($list, '0', 'Не используется');
        $list = array_add($list, 'parent', 'Раздел блог');
        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();

        foreach ($categories as $category) {
            if ($category->parent_id === 0) {
                $list[$category->title] = [];
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $this->content = view(env('THEME') . '.admin.menus_create_content')
            ->with([
                'menus' => $menus,
                'articles' => $articles,
                'filters' => $filters,
                'portfolios' => $portfolios,
                'categories' => $list,
            ])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenusRequest $request)
    {
        $result = $this->m_rep->addMenu($request);

        if (is_array($request) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);

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
