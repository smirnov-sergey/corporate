@foreach($items as $item)
    <li {{ (URL::current() == $item->url()) ? 'class=active' : '' }}>
        <a href="{{ $item->url()}}">{{ $item->title }}</a>

        @if($item->hasChildren())
            <ul class="sub-menu">
                @include(config('settings.theme') . '.custom_menu_items', ['items' => $item->children()])
            </ul>
        @endif
    </li>
@endforeach