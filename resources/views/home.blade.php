@extends('layouts.app')

@section('content')
    @each('user.courses.progress', $userCourses, 'userCourse')

    @isset($courses)
        <h3 class="text-center mb-3 font-weight-normal">{{ __('Here are some courses you might be interested in.') }}</h3>
        @include('courses.list')
    @endisset
@endsection
