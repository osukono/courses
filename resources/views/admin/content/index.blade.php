@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.index') }}
@endsection

@section('toolbar')
    @canany([\App\Library\Permissions::create_content, \App\Library\Permissions::restore_content])
        <div class="btn-group" role="group">
            @can(\App\Library\Permissions::create_content)
                @include('admin.components.menu.create', ['route' => route('admin.content.create'), 'title' => __('admin.menu.create.content')])
            @endcan
            @can(\App\Library\Permissions::restore_content)
                @include('admin.components.menu.trash', ['trashed' => $trashed, 'route' => route('admin.content.trash')])
            @endcan
        </div>
    @endcanany
@endsection

@section('content')
    @if($contents->count())
        @include('admin.content.list')
    @endif
@endsection
