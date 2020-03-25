@extends('layouts/app')

@section('content')
    @include('layouts.header', [
    'header_img' => URL::asset('images/index.svg?v=3'),
    'header_img_sm' => URL::asset('images/index_sm.svg'),
    'header_title' => __('web.index.section.top.header'),
    'header_text' => __('web.index.section.top.text'),
    'header_button_link' => '#apps',
    'header_button_caption' => __('web.index.section.top.button')
    ])

    <div class="container-fluid d-block d-md-none">
        <hr>
    </div>

    <div id="apps" class="container pt-4">
        <div class="row">
            <div class="d-none col-5 text-center d-lg-table-cell">
                <img src="{{ URL::asset('/images/' . __('web.index.section.app.screen')) }}"
                     class="w-50 border rounded shadow" alt="Yummy Lingo's application">
            </div>
            <div class="col-10 offset-1 text-center col-lg-7 offset-lg-0 text-md-left">
                <h1 class="text-primary">{{ __('web.index.section.app.header') }}</h1>
                <div class="lead mt-4">{!! __('web.index.section.app.description') !!}</div>
                <div class="mt-4 text-center text-md-left">
                    <a href="{{ __('web.index.section.app.links.android') }}" target="_blank"><img
                            src="{{ URL::asset('images/google_play.svg') }}" alt="Google Play" width="148" height="44"></a>
                    <a href="{{ __('web.index.section.app.links.ios') }}" target="_blank"><img
                            class="mt-md-0 ml-md-1 mt-1 ml-0" src="{{ URL::asset('images/app_store.svg') }}"
                            alt="App Store" width="148" height="44"></a>
                </div>
            </div>
        </div>
    </div>

    @if(!$courses->isEmpty())
        <div class="container-fluid mt-5" style="background-color: #D9DFF6;">
            <div class="container">
                <div class="row py-3">
                    <div class="col-12 col-md-8 text-center align-self-center">
                        <h4 class="text-primary mb-0">
                            {{ __('web.index.section.promo.text', ['course' => $courses->first()->language->name . ' ' . $courses->first()->level->name]) }}
                        </h4>
                    </div>
                    <div class="col-12 text-center pt-3 pl-0 pr-0 col-md-4 pt-md-0 pr-md-5">
                        <a class="btn btn-primary btn-lg rounded-pill shadow-sm"
                           href="https://play.google.com/store/apps/details?id=com.yummylingo.app">{{ __('web.index.section.promo.button') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row pt-5 pb-4">
            <div class="d-none d-lg-table-cell col-lg-5">
                <img src="{{ URL::asset('/images/courses.svg') }}" class="w-100">
            </div>
            <div class="col-10 offset-1 col-lg-7 offset-lg-0">
                <div class="row mb-4">
                    <div class="col"><h1 class="text-primary">{{ __('web.index.section.courses.header') }}</h1></div>
                </div>
                @foreach($courses as $course)
                    <div class="row">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-7 order-1">
                                    <h2 class="text-dark text-nowrap">{{ $course->language->name . ' ' . $course->level->name }}</h2>
                                </div>
                                <div class="col-6 order-3 col-md order-md-2 text-right">
                                    <a class="font-weight-bold text-nowrap align-middle" data-toggle="collapse"
                                       href="#course-{{ $course->id }}-lessons" role="button" aria-expanded="false"
                                       aria-controls="course-{{ $course->id }}-lessons">
                                        {{ __('web.index.section.courses.learn_more') }}
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.99987 4.97656L10.1249 0.851562L11.3032 2.0299L5.99987 7.33323L0.696533 2.0299L1.87487 0.851562L5.99987 4.97656Z"
                                                fill="currentColor"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="col-6 order-2 col-md order-md-3">
                                    <a class="btn btn-outline-primary btn-lg rounded-pill"
                                       href="#apps">{{ __('web.index.section.courses.demo') }}</a>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <span class="lead">{!! nl2br(e($course->description)) !!}</span>
                                </div>
                            </div>
                            <div class="row collapse" id="course-{{ $course->id }}-lessons">
                                <div class="col pt-3">
                                    <div class="row">
                                        <div class="col"><h4>{{ __('web.index.section.courses.lessons') }}</h4></div>
                                    </div>
                                    <div class="row">
                                        @foreach($course->courseLessons->chunk(ceil($course->courseLessons->count() / 2)) as $chunk)
                                            <div class="col-12 col-md-6">
                                                <table class="table table-sm table-borderless mb-0">
                                                    <tbody>
                                                    @foreach($chunk as $courseLesson)
                                                        <tr>
                                                            <td>{{ $courseLesson->index . '. ' . $courseLesson->title }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if(! $loop->last)
                                <div class="row my-2">
                                    <div class="col">
                                        <hr>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
