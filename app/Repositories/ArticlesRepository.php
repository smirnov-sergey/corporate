<?php

namespace App\Repositories;

use App\Article;
use Illuminate\Support\Facades\Gate;

class ArticlesRepository extends Repository
{
    public function __construct(Article $articles)
    {
        $this->model = $articles;
    }

    public function one($alias =false, $attr = [])
    {
        $article = parent::one($alias, $attr);

        if ($article && !empty($attr)) {
            $article->load('comments');
            $article->comments->load('user');
        }

        return $article;
    }

    public function addArticle($request)
    {
        if (Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image');

        if (empty($data)) {
            return ['error' => 'Данных нет'];
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }
    }
}