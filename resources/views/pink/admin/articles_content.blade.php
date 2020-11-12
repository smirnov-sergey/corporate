<?php
/**
 * @var $articles App\Article
 * @var $article App\Article
 */
?>

@if($articles)
    <div id="content-page" class="content group">
        <div class="hentry group">
            <h2>Добавленные статьи</h2>
            <div class="short-table white">
                <table style="width: 100%" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="align-left">ID</th>
                        <th>Заголовок</th>
                        <th>Текст</th>
                        <th>Изображение</th>
                        <th>Категория</th>
                        <th>Псевдоним</th>
                        <th>Действие</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td class="align-left">{{ $article->id }}</td>
                            <td class="align-left">{!! Html::link(route('admin.articles.edit', ['articles' => $article->alias])) !!}</td>
                            <td class="align-left">{{ str_limit($article->text, 200) }}</td>
                            <td>
                                @if(isset($article->img->mini))
                                    {!! Html::image(asset(env('THEME'))) . '/image/articles/' . $article->img->mini !!}
                                @endif
                            </td>
                            <td>{{ $article->category->title }}</td>
                            <td>{{ $article->alias }}</td>
                            <td>
                                {!! Form::open([
                                    'url' => route('admin.articles.destroy', ['articles' => $article->alias]),
                                    'class' => 'form-horizontal',
                                    'method' => 'POST'
                                ]) !!}
                                {{ method_field('DELETE') }}
                                {!! Form::button('Удалить', ['class' => 'btn btn-french-5', 'type' => 'submit']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {!! Html::link(
                route('admin.articles.create'),
                'Добавить материал',
                ['class' => 'btn btn-french-1']
            ) !!}
        </div>
    </div>
@endif