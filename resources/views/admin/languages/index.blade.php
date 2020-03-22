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
    @if($languages->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Languages</h5>
                @include('admin.languages.list')
            </div>
        </div>
    @endif
@endsection
