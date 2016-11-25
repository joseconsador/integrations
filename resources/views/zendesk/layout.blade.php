@extends('base.layout')

@section('base_header')
    <link rel="stylesheet" href="{{ elixir('css/zendesk.css') }}"/>
@endsection

@section('base_content')
    <div class="container">
        @yield('content')
    </div>
@endsection

@section('base_footer')
    @yield('scripts')
@endsection
