@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.index') }}
@endsection

@section('content')
    @if($users->count())
        <div class="card">
            <div class="card-body">
                @include('admin.users.list')
            </div>
        </div>
    @endif
@endsection
