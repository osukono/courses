@extends('layouts.app')

@section('content')
    <div style="background-color: #F9F8F8">
        <div class="container">

        </div>
    </div>
    @each('user.courses.progress', $userCourses, 'userCourse')

    @if($userCourses->count() == 0)
        <h3 class="text-center mt-4 mb-5 font-weight-normal">{{ __('A great point to start') }}</h3>
    @endif

{{--    @includeWhen($courses->count() > 0, 'courses.list')--}}
@endsection
