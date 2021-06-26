@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dashboard') }}
@endsection

@section('content')
    <div class="row">
        @include('admin.card', ['title' => __('admin.dashboard.cards.users.title'), 'body' => $users_count])
        @include('admin.card', ['title' => __('admin.dashboard.cards.courses.title'), 'body' => $courses_count])
        @include('admin.card', ['title' => __('admin.dashboard.cards.statistics.lessons.title'), 'body' => $lessons_learned])
        @include('admin.card', ['title' => __('admin.dashboard.cards.statistics.development.title'), 'body' => __('admin.dashboard.cards.statistics.development.value', ['num' => $devActivity])])
    </div>
@endsection
