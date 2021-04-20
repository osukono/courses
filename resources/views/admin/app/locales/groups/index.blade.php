@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locale.groups.index') }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="Create Group"
                  route="{{ route('admin.app.locale.groups.create') }}">
            <icon-plus></icon-plus>
        </v-button>
    </v-button-group>
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
