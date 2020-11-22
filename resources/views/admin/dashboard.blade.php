@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Users</h5>
                    <div class="h3">{{ $users_count }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Courses</h5>
                    <div class="h3">{{ $courses_count }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Lessons Learned</h5>
                    <div class="h3">{{ $lessons_learned }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
