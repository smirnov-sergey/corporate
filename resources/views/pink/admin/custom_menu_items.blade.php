<?php
/**
 * @var $items App\Menu
 * @var $item App\Menu
 */
?>

@foreach($items as $item)
    <tr>
        <td style="text-align: left">
            {{ $padding_left }}
            {!! Html::link(route('admin.menus.edit', ['menus' => $item->id]), $item->title) !!}
        </td>
        <td>{{ $item->url() }}</td>
        <td>
            {!! Form::open([
                'url' => route('admin.menus.destroy', ['menus' => $item->id]),
                'class' => 'form-horizontal',
                'method' => 'POST'
            ]) !!}
            {{ method_field('DELETE') }}
            {!! Form::button('Удалить', ['class' => 'btn btn-french-5', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </td>
    </tr>

    @if($item->hasChildren())
        @include(env('THEME') . '.admin.custom_menu_items', ['items' => $item->children(), 'padding_left' => $padding_left . '--'])
    @endif
@endforeach

