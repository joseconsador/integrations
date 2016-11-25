@extends('zendesk.layout')

@section('base_content')
    <div id="app" class="container l-grid l-grid--0 u-mv-lg u-ta-center">
        <div class="u-ta-center">
            <div class="header u-mg-lg u-giga u-light success-wrapper">{!! trans('descriptions.success.title') !!}</div>
            <div class="success-wrapper">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
