@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locales.index') }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group" role="group">
            <button class="btn btn-info" type="button" data-toggle="tooltip" data-title="Download from Firebase"
                    onclick="$('#download-locales').submit();">
                @include('admin.components.svg.download')
            </button>
            <form class="d-none" id="download-locales" action="{{ route('admin.app.locales.download') }}" method="post">
                @csrf
            </form>
            <button class="btn btn-info" type="button" data-toggle="tooltip" data-title="Upload to Firebase"
                    onclick="$('#upload-locales').submit();">
                @include('admin.components.svg.upload')
            </button>
            <form class="d-none" id="upload-locales" action="{{ route('admin.app.locales.upload') }}" method="post">
                @csrf
            </form>
            <a class="btn btn-info" href="{{ route('admin.app.locale.groups.index') }}">Groups</a>
        </div>
    </div>
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
