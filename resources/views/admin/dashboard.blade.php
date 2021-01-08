@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-auto mb-4 px-0 mx-3" style="min-width: 300px">
            <div class="card shadow-sm">
                <div class="card-header">
                    Users
                </div>
                <div class="card-body">
                    <h3>{{ $users_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-auto mb-4 px-0 mx-3" style="min-width: 300px">
            <div class="card shadow-sm">
                <div class="card-header">
                    Courses
                </div>
                <div class="card-body">
                    <h3>{{ $courses_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-auto mb-4 px-0 mx-3" style="min-width: 300px">
            <div class="card shadow-sm">
                <div class="card-header">
                    Lessons Learned
                </div>
                <div class="card-body">
                    <h3>{{ $lessons_learned }}</h3>
                </div>
            </div>
        </div>
        <div class="col-auto mb-4 px-0 mx-3" style="min-width: 300px">
            <div class="card shadow-sm">
                <div class="card-header">
                    Development Activity (last month)
                </div>
                <div class="card-body">
                    <h3>{{ $devActivity }} changes</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
