@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col text-left">
                @isset($previous)
                    <a href="{{ route('grammar', $previous) }}">&lsaquo; {{ $previous->title }}</a>
                @endisset
            </div>
            <div class="col text-right">
                @isset($next)
                    <a href="{{ route('grammar', $next) }}">{{ $next->title }} &rsaquo;</a>
                @endisset
            </div>
        </div>
        <h3 class="text-center mt-4">{{ $course }}</h3>
        <h4 class="text-center mt-2">{{ $title }}</h4>
        <div class="my-5 mx-0 mx-md-3 mx-lg-5">
            {!! $grammar !!}
        </div>
    </div>
@endsection
