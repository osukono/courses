@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.exercises.show', $exercise) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group">
            @isset($previous)
                @include('admin.components.menu.previous', ['route' => route('admin.exercises.show', $previous)])
            @endisset

            @isset($next)
                @include('admin.components.menu.next', ['route' => route('admin.exercises.show', $next)])
            @endisset
        </div>

        @can(\App\Library\Permissions::update_content)
            <div class="btn-group ml-2" role="group">
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" id="create" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        @include('admin.components.svg.plus')
                    </button>
                    <div class="dropdown-menu" aria-labelledby="create">
                        @foreach($fields as $field)
                            <button class="dropdown-item" type="button" onclick="document.getElementById('field-{{ $field->id }}').submit();">{{ $field }}</button>
                            <form class="d-none" id="field-{{ $field->id }}" action="{{ route('admin.exercise.fields.store', $exercise) }}" method="post">
                                @csrf
                                <input type="hidden" name="field_id" value="{{ $field->id }}">
                            </form>
                        @endforeach
                    </div>
                </div>

                <div class="btn-group" role="group">
                    <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        @include('admin.components.svg.more-vertical')
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
                        <form class="d-none" id="delete" action="{{ route('admin.exercises.destroy', $exercise) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                        <button class="dropdown-item" type="button"
                                data-toggle="confirmation"
                                data-btn-ok-label="{{ __('admin.form.delete') }}"
                                data-title="{{ __('admin.form.delete_confirmation', ['object' => 'Exercise ' . $exercise->index]) }}"
                                data-form="delete">
                            Delete
                        </button>
                        <a class="dropdown-item" href="{{ route('admin.exercise.fields.trash', $exercise) }}">Trash</a>
                    </div>
                </div>

                @can(\App\Library\Permissions::view_translations && $languages->isNotEmpty())
                    @include('admin.components.menu.translations', ['route' => 'admin.translations.exercise.show', 'arg' => $exercise])
                @endcan
            </div>
        @endcan
    </div>
@endsection

@section('content')
    @if($exerciseFields->count() > 0)
        @include('admin.content.exercises.fields.list')
    @endif
@endsection

@push('scripts')
    @include('admin.components.audio.player')
@endpush
