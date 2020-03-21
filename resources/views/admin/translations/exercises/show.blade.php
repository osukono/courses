@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.exercise.show', $language, $exercise) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group" role="group">
            @isset($previous)
                @include('admin.components.menu.previous', ['route' => route('admin.translations.exercise.show', [$language, $previous])])
            @endisset

            @isset($next)
                @include('admin.components.menu.next', ['route' => route('admin.translations.exercise.show', [$language, $next])])
            @endisset
        </div>

        <div class="btn-group ml-2" role="group">
            @can($languages->isNotEmpty())
                @include('admin.components.menu.translations', ['route' => 'admin.translations.exercise.show', 'arg' => $exercise])
            @endcan

            @can(\App\Library\Permissions::view_content)
                <a class="btn btn-info" href="{{ route('admin.exercises.show', $exercise) }}">
                    Content @include('admin.components.svg.chevron-right')
                </a>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <h4>{{ $language->native }}</h4>

    @includeWhen($exerciseData->count(), 'admin.translations.exercises.data.list')
@endsection

@push('scripts')
    @include('admin.components.audio.player')
@endpush
