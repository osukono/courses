@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.index') }}
@endsection

@section('content')
    @if($courses->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Courses</h5>
                @include('admin.courses.list')
            </div>
        </div>
    @endif
@endsection
