@extends('layouts/app')

@section('content')
    @include('components.header', [
    'header_img' => URL::asset('images/index.svg?v=15'),
    'header_img_sm' => URL::asset('images/index_sm.svg?v=5'),
    'header_title' => __('web.index.section.top.header'),
    'header_text' => __('web.index.section.top.text'),
    'header_button_link' => '#apps',
    'header_button_caption' => __('web.index.section.top.button')
    ])

    <div class="container-fluid d-block d-md-none">
        <hr>
    </div>

    @include('index.app')

    @if(!$courses->isEmpty())
        @include('index.promo')
        @include('index.courses')
    @endif
@endsection
