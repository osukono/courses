@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.index') }}
@endsection

@section('content')
    @if($courses->count())
        <div class="card">
            <div class="card-body">
                @include('admin.courses.list')
            </div>
        </div>
    @endif
@endsection
