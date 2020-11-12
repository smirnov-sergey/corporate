<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticlesRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class ArticlesController extends AdminController
{
    public function __construct(ArticlesRepository $a_rep)
    {
        parent::__construct();

        if (!Gate::denies('VIEW_ADMIN_ARTICLES')) {
            abort(403);
        }

        $this->a_rep = $a_rep;
        $this->template = env('THEME') . '.admin.articles';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index()
    {
        $this->title = 'Менеджер статей';

        $articles = $this->getArticles();

        $this->content = view(env('THEME') . '.admin.articles_content')
            ->with('articles', $articles)
            ->render();

        return $this->renderOutput();
    }

    private function getArticles()
    {
        return $this->a_rep->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Throwable
     */
    public function create()
    {
        if (Gate::allows('save', new Article())) {
            abort(403);
        }

        $this->title = 'Добавить новый материал';

        $lists = [];
        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();

        foreach ($categories as $category) {
            if ($category->parent_id === 0) {
                $lists[$category->title] = [];
            } else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->content = view(env('THEME') . '.admin.articles_create_content')
            ->with('categories', $lists)
            ->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $result = $this->a_rep->addArticle($request);

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
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|void
     * @throws \Throwable
     */
    public function edit(Article $article)
    {
        if (Gate::allows('edit', new Article())) {
            abort(403);
        }

        $article->img = json_decode($article->img);

        $lists = [];
        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();

        foreach ($categories as $category) {
            if ($category->parent_id === 0) {
                $lists[$category->title] = [];
            } else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->title = 'Редактирование материала - ' . $article->title;

        $this->content = view(env('THEME') . '.admin.articles_create_content')
            ->with([
                'categories' => $lists,
                'article' => $article
            ])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return void
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $result = $this->a_rep->updateArticle($request, $article);

        if (is_array($request) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
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
}
