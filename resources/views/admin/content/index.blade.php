@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.index') }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="{{ __('admin.dev.courses.toolbar.create') }}"
                  route="{{ route('admin.content.create') }}"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::create_content) }}">
            {{ __('admin.dev.courses.toolbar.create') }}
        </v-button>
        <v-button tooltip="{{ __('admin.dev.courses.toolbar.trash') }}"
                  route="{{ route('admin.content.trash') }}"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::restore_content) }}">
            <icon-trash trashed="{{ $trashed }}"></icon-trash>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if($contents->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">{{ __('admin.dev.courses.title') }}</h5>
                @include('admin.content.list')
            </div>
        </div>
    @endif
@endsection
