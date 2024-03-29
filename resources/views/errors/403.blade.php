@extends('layouts.app')

@section('content')
    @include('components.header', [
    'header_img' => URL::asset('images/401.svg?v=3'),
    'header_img_sm' => URL::asset('images/401_sm.svg?v=5'),
    'header_title' => __('web.errors.403.title'),
    'header_text' => __('web.errors.403.text'),
    'header_button_link' => route("welcome"),
    'header_button_caption' => __('web.errors.403.button')
    ])
@endsection
