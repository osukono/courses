@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dashboard') }}
@endsection

@section('content')
    {{--<div>
        Users : {{ $userCount }}
    </div>
    <div>
        User Courses : {{ $userCoursesCount }}
    </div>--}}
@endsection
