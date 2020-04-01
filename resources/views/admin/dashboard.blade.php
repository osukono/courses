@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Users</h5>
                    <div class="h3">{{ $users }}</div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Contents</h5>
                    <div class="h3">{{ $contents }}</div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Courses</h5>
                    <div class="h3">{{ $courses }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
