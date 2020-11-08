@extends(env('THEME') . '.layouts.site')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('bar')
    {!! $right_bar !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection