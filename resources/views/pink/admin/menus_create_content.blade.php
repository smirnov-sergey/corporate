<?php
/**
 * @var $menus App\Menu
 * @var $articles App\Article
 * @var $filters App\Filter
 * @var $portfolios App\Portfolio
 * @var $categories App\Category
 */
?>

<div id="content-page" class="content group">
    <div class="hentry group">
        {!! Form::open([
            'url' => (isset($menu->id))
                ? route('admin.menus.update', ['menus' => $menu->id])
                : route('admin.menus.store'),
            'class' => 'contact-form',
            'method' => 'POST'
        ]) !!}

        <ul>
            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">Заголовок:</span>
                    <br/>
                    <span class="sublabel">Заголовок пункта</span>
                </label>
                <div class="input-prepend">
                    <span class="add-on">
                        <i class="icon-user"></i>
                    </span>
                    {!! Form::text(
                       'title',
                       isset($menu->title) ? $menu->title : old('title'),
                       ['placeholder' => 'Введите название страницы']
                    ) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">Родительский пункт меню:</span>
                    <br/>
                    <span class="sublabel">Родитель</span>
                </label>
                <div class="input-prepend">
                    {!! Form::select(
                       'parent',
                       $menus,
                       isset($menu->title) ? $menu->parent : null
                    ) !!}
                </div>
            </li>
        </ul>

        <h1>Тип меню:</h1>

        <div id="accordion">
            <h3>
                {!! Form::radio(
                    'type',
                    'customLink',
                    (isset($type) && $type == 'customLink') ? true : false,
                    ['class' => 'radioMenu']
                ) !!}
                <span class="label">Пользовательская ссылка</span>
            </h3>

            <ul>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Путь для ссылки:</span>
                        <br/>
                        <span class="sublabel">Путь для ссылки</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <span class="add-on">
                          <i class="icon-user"></i>
                        </span>
                        {!! Form::text(
                            'custom_link',
                            isset($menu->path) ? $menu->path : old('path'),
                            ['placeholder' => 'Введите путь для ссылки']
                        ) !!}
                    </div>
                </li>
                <div style="clear:both;"></div>
            </ul>

            <h3>
                {!! Form::radio(
                    'type',
                    'blogLink',
                    (isset($type) && $type == 'blockLink') ? true : false,
                    ['class' => 'radioMenu']
                ) !!}
                <span class="label">Раздел блог:</span>
            </h3>

            <ul>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Ссылка на категорию блога:</span>
                        <br/>
                        <span class="sublabel">Ссылка на категорию блога</span>
                    </label>
                    <div class="input-prepend">
                        @if($categories)
                            {!! Form::select(
                               'category_alias',
                               $categories,
                               (isset($option) && $option) ? $option : false
                            ) !!}
                        @endif
                    </div>
                </li>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Ссылка на материал блога:</span>
                        <br/>
                        <span class="sublabel">Ссылка на материал блога</span>
                    </label>
                    <div class="input-prepend">
                        @if($articles)
                            {!! Form::select(
                               'article_alias',
                               $articles,
                               isset($option) ? $option : false,
                               ['placeholder' => 'Не используется']
                            ) !!}
                        @endif
                    </div>
                </li>
            </ul>

            <h3>
                {!! Form::radio(
                    'type',
                    'portfolioLink',
                    (isset($type) && $type == 'portfolioLink') ? true : false,
                    ['class' => 'radioMenu']
                ) !!}
                <span class="label">Раздел портфолио:</span>
            </h3>

            <ul>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Ссылка на запись портфолио:</span>
                        <br/>
                        <span class="sublabel">Ссылка на запись портфолио</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        {!! Form::select(
                            'portfolio_alias',
                            $portfolios,
                            isset($option) ? $option : null
                        ) !!}
                    </div>
                </li>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Портфолио</span>
                        <br/>
                        <span class="sublabel">Портфолио</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        {!! Form::select(
                            'filter_alias',
                            $filters,
                            isset($option) ? $option : null
                        ) !!}
                    </div>
                </li>
            </ul>
        </div>
        <br/>

        @if(isset($menu_id))
            <input type="hidden" name="_method" value="PUT">
        @endif

        <ul>
            <li class="submit-button">
                {!! Form::button('Сохранить', ['class' => 'btn btn-french-1', 'type' => 'submit']) !!}
            </li>
        </ul>

        {!! Form::close() !!}
    </div>
</div>

<script>
    jQuery(function ($) {
        $('#accordion').accordion({
            activate: function (e, obj) {
                obj.newPanel.prev()
                    .find('input[type=radio]')
                    .attr('checked', 'checked');
            }
        });

        let active = 0;

        $('#accordion input[type=radio]').each(function (index, it) {
            if ($(this).prop('checked')) {
                active = index;
            }
        });

        $('#accordion').accordion('option', 'active', active);

        $('input[type=radio]').css('-webkit-appearance', 'auto');
    })
</script>