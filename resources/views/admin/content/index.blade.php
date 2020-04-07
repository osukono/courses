@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.index') }}
@endsection

@section('toolbar')
    <toolbar-group
        visible="{{ Auth::getUser()->can(App\Library\Permissions::create_content) | Auth::getUser()->can(\App\Library\Permissions::restore_content) }}">
        <toolbar-button tooltip="Create Content"
                        route="{{ route('admin.content.create') }}"
                        visible="{{ Auth::getUser()->can(\App\Library\Permissions::create_content) }}"
        >
            <icon-plus></icon-plus>
        </toolbar-button>
        <toolbar-button tooltip="Trash"
                        route="{{ route('admin.content.trash') }}"
                        visible="{{ Auth::getUser()->can(\App\Library\Permissions::restore_content) }}"
        >
            <icon-trash trashed="{{ $trashed }}"></icon-trash>
        </toolbar-button>
    </toolbar-group>
@endsection

@section('content')
    @if($contents->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Content</h5>
                @include('admin.content.list')
            </div>
        </div>
    @endif
@endsection

