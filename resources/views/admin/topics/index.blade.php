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
    @includeWhen($topics->count(), 'admin.topics.list')
@endsection
