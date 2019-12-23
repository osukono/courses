@extends('layouts/app')

@section('content')
    <h3 class="text-center mt-4 mb-5 font-weight-normal">{{ __('A simple but powerful technique to improve your English.') }}</h3>
    {{--<p class="mb-4">
        {{ __('web.index.description.1') }}
        {{ __('web.index.description.2') }}
    </p>--}}
    @includeWhen($courses->count() > 0, 'courses.list')
@endsection
