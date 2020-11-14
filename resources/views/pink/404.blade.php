@extends(config('settings.theme') . '.layouts.site')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    <div id="content-index" class="content group">
        <img class="error-404-image group"
             src="{{ asset(config('settings.theme')) }}/images/features/404.png"
             title="Error 404"
             alt="404"
        />
        <div class="error-404-text group">
            <p>Сожалеем, но страница, которую вы ищете, не существует.</p>
        </div>
    </div>
@endsection

@section('footer')
    @include(config('settings.theme') . '.footer')
@endsection

