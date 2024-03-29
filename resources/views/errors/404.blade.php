@extends('layouts.app')

@section('content')
    @include('components.header', [
    'header_img' => URL::asset('images/404.svg?v=4'),
    'header_img_sm' => URL::asset('images/404_sm.svg?v=5'),
    'header_title' => __('web.errors.404.title'),
    'header_text' => __('web.errors.404.text'),
    'header_button_link' => route("welcome"),
    'header_button_caption' => __('web.errors.404.button')
    ])
@endsection
