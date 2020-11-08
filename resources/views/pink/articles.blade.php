@extends(env('THEME') . '.layouts.site')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('bar')
    {!! $right_bar  or '' !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection