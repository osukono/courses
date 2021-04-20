@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.topics.index') }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="Create Topic"
                  route="{{ route('admin.topics.create') }}">
            <icon-plus></icon-plus>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if($topics->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Topics</h5>
                @include('admin.topics.list')
            </div>
        </div>
    @endif
@endsection
