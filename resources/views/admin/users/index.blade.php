@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.index') }}
@endsection

@section('content')
    @if($users->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Users</h5>
                @include('admin.users.list')
            </div>
        </div>
    @endif
@endsection
