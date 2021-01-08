@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dashboard') }}
@endsection

@section('content')
    <div class="row">
        @include('admin.card', ['title' => 'Users', 'body' => $users_count])
        @include('admin.card', ['title' => 'Courses', 'body' => $courses_count])
        @include('admin.card', ['title' => 'Lessons Learned', 'body' => $lessons_learned])
        @include('admin.card', ['title' => 'Development Activity (last month)', 'body' => $devActivity . ' changes'])
    </div>
@endsection
