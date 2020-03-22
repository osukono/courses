@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.topics.index') }}
@endsection

@section('toolbar')
    <div class="btn-group" role="group">
        @include('admin.components.menu.create', ['route' => route('admin.topics.create'), 'title' => 'Create Topic'])
    </div>
@endsection

@section('content')
    @if($topics->count())
        <div class="card shadow-sm">
            <div class="card-body">
                @include('admin.topics.list')
            </div>
        </div>
    @endif
@endsection
