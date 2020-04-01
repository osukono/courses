@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locale.groups.index') }}
@endsection

@section('toolbar')
    <div class="btn-group" role="group">
        @include('admin.components.menu.create', ['route' => route('admin.app.locale.groups.create'), 'title' => 'Create Group'])
    </div>
@endsection

@section('content')
    @if($localeGroups->isNotEmpty())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Groups</h5>

                @include('admin.app.locales.groups.list')
            </div>
        </div>
    @endif
@endsection
