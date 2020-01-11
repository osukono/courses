@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.languages.index') }}
@endsection

@section('toolbar')
    <div class="btn-group" role="group">
        @include('admin.components.menu.create', ['route' => route('admin.languages.create'), 'title' => 'Create Language'])
    </div>
@endsection

@section('content')
    @includeWhen($languages->count(), 'admin.languages.list')
@endsection
