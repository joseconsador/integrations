@extends('zendesk.layout')

@section('base_content')
    <div id="app" class="container l-grid l-grid--0 u-mv-lg u-ta-center">
        <div class="u-ta-center">
            <div class="header u-mg-lg u-giga u-light success-wrapper">{!! trans('descriptions.success.title') !!}</div>
            <div class="success-wrapper">
                <img src="{{ secure_asset('images/success.png') }}" alt="success image">
            </div>
        </div>
    </div>
@endsection
