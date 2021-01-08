@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 mb-3 pr-0">
            <div class="card shadow-sm">
                <div class="card-header">
                    Users
                </div>
                <div class="card-body">
                    <h3>{{ $users_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-3 pr-0">
            <div class="card shadow-sm">
                <div class="card-header">
                    Courses
                </div>
                <div class="card-body">
                    <h3>{{ $courses_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    Lessons Learned
                </div>
                <div class="card-body">
                    <h3>{{ $lessons_learned }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
