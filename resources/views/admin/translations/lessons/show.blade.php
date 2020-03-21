@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.lesson.show', $language, $lesson) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group" role="group">
            @isset($previous)
                @include('admin.components.menu.previous', ['route' => route('admin.translations.lesson.show', [$language, $previous])])
            @endisset

            @isset($next)
                @include('admin.components.menu.next', ['route' => route('admin.translations.lesson.show', [$language, $next])])
            @endisset
        </div>

        <div class="btn-group ml-2" role="group">
            @can($languages->isNotEmpty())
                @include('admin.components.menu.translations', ['route' => 'admin.translations.lesson.show', 'arg' => $lesson])
            @endcan

            @can(\App\Library\Permissions::view_content)
                <a class="btn btn-info" href="{{ route('admin.lessons.show', $lesson) }}">
                    Content @include('admin.components.svg.chevron-right')
                </a>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <h4>{{ $language->native }}</h4>

    @if($exercises->count())
        @include('admin.translations.exercises.list')
    @endif
@endsection

@push('scripts')
    @include('admin.components.audio.player')
@endpush
