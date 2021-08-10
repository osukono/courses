@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col text-start">
                @isset($previous)
                    <a href="{{ route('grammar', $previous) }}">&lsaquo;&nbsp;{{ $previous->title }}</a>
                @endisset
            </div>
            <div class="col text-end">
                @isset($next)
                    <a href="{{ route('grammar', $next) }}">{{ $next->title }}&nbsp;&rsaquo;</a>
                @endisset
            </div>
        </div>
        <h4 class="text-center mt-4 text-dark">{{ $course }}</h4>
        <h5 class="text-center mt-2 text-dark   ">{{ $title }}</h5>
        <div class="my-5 mx-0 mx-md-3 mx-lg-5">
            {!! $grammar !!}
        </div>
    </div>
@endsection
