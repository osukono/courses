@extends('layouts.app')

@section('content')
    @each('user.courses.progress', $userCourses, 'userCourse')

    @if($courses->count())
        @include('courses.list')
    @endif
@endsection
