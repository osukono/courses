@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.lessons.show', $lesson) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group">
            @isset($previous)
                @include('admin.components.menu.previous', ['route' => route('admin.lessons.show', $previous)])
            @endisset

            @isset($next)
                @include('admin.components.menu.next', ['route' => route('admin.lessons.show', $next)])
            @endisset
        </div>

        @can(\App\Library\Permissions::update_content)
            <div class="btn-group ml-2" role="group">
                <a class="btn btn-info" href="#" data-toggle="tooltip" data-title="{{ __('admin.menu.create.exercise') }}"
                   onclick="document.getElementById('exercise-create').submit();">
                    @include('admin.components.svg.plus')
                </a>
                <form id="exercise-create" class="d-none" action="{{ route('admin.exercises.store', $lesson) }}" method="post">
                    @csrf
                </form>

                <div class="btn-group" role="group">
                    <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        @include('admin.components.svg.more-vertical')
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
                        <a class="dropdown-item" href="{{ route('admin.lessons.edit', $lesson) }}">Properties</a>
                        <div class="dropdown-divider"></div>
                        <form class="d-none" id="lesson-{{ $lesson->id }}-delete" action="{{ route('admin.lessons.destroy', $lesson) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                        <button class="dropdown-item text-danger" type="button"
                           data-toggle="confirmation"
                           data-btn-ok-label="{{ __('admin.form.delete') }}"
                           data-title="{{ __('admin.form.delete_confirmation', ['object' => $lesson]) }}"
                           data-form="lesson-{{ $lesson->id }}-delete">
                            Delete Lesson
                        </button>
                        <a class="dropdown-item" href="{{ route('admin.exercises.trash', $lesson) }}">Trash</a>
                    </div>
                </div>

                @can(\App\Library\Permissions::view_translations && $languages->isNotEmpty())
                    @include('admin.components.menu.translations', ['route' => 'admin.translations.lesson.show', 'arg' => $lesson])
                @endcan
            </div>
        @endcan
    </div>
@endsection

@section('content')
    @if($exercises->count())
        @include('admin.content.exercises.list')
    @endif
@endsection

@push('scripts')
    @include('admin.components.audio.player')
@endpush
