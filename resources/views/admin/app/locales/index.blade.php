@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locales.index') }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="Create"
                  route="{{ route('admin.app.locales.create') }}">
            <template v-slot:icon>
                <icon-plus></icon-plus>
            </template>
        </v-button>
        <v-button tooltip="Download from Firebase"
                  submit="#download-locales">
            <template v-slot:icon>
                <icon-download></icon-download>
            </template>
            @push('forms')
                <form class="d-none" id="download-locales" action="{{ route('admin.app.locales.download') }}" method="post">
                    @csrf
                </form>
            @endpush
        </v-button>
        <v-button tooltip="Upload to Firebase"
                  submit="#upload-locales">
            <template v-slot:icon>
                <icon-upload></icon-upload>
            </template>
        </v-button>
        <v-button route="{{ route('admin.app.locale.groups.index') }}">
            <template v-slot:label>
                Groups
            </template>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if ($appLocales->isNotEmpty())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Localizations ({{ $appLocales->count() }})</h5>
                @include('admin.app.locales.list')
            </div>
        </div>
    @endif

    @if (Session::has('job'))
        @push('progress')
            <job-status job-id="{{ Session::get('job') }}"
                        job-status-url="{{ route('admin.jobs.status', Session::get('job')) }}"
                        redirect-url="{{ route('admin.app.locales.index') }}"
            ></job-status>
        @endpush
    @endif
@endsection
