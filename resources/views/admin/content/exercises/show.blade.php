@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.exercises.show', $exercise) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button id="previous" route="{{ route('admin.exercises.show', $previous) }}">
                <template v-slot:icon>
                    <icon-chevron-left></icon-chevron-left>
                </template>
            </v-button>
        @endisset
        @isset($next)
            <v-button id="next" route="{{ route('admin.exercises.show', $next) }}">
                <template v-slot:icon>
                    <icon-chevron-right></icon-chevron-right>
                </template>
            </v-button>
        @endisset
    </v-button-group>

    <v-button-group>
        <v-button tooltip="Add Sentence"
                  submit="sentence-create"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
            <template v-slot:label>
                Sentence
            </template>
            <template v-slot:icon>
                <icon-plus></icon-plus>
            </template>
            @push('forms')
                <form id="sentence-create" class="d-none" action="{{ route('admin.exercise.data.create', $exercise) }}"
                      method="post" autocomplete="off">
                    @csrf
                </form>
            @endpush
        </v-button>

        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>

            <v-dropdown-group>
                <v-dropdown-item label="{{ $exercise->isDisabled($content->language) ? 'Enable' : 'Disable' }}"
                                 submit="#exercise-{{ $exercise->id }}-{{ $exercise->isDisabled($content->language) ? 'enable' : 'disable' }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}"
                >
                    @push('forms')
                        <form class="d-none"
                              action="{{ route('admin.exercises.' . ($exercise->isDisabled($content->language) ? 'enable' : 'disable'), $exercise) }}"
                              method="post"
                              id="exercise-{{ $exercise->id }}-{{ $exercise->isDisabled($content->language) ? 'enable' : 'disable' }}">
                            @csrf
                            @method('patch')
                        </form>
                    @endpush
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-modal label="Delete Exercise"
                                  modal="exercise-{{ $exercise->id }}-modal-delete"
                                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                    @push('forms')
                        <form class="d-none" id="exercise-{{ $exercise->id }}-delete" action="{{ route('admin.exercises.destroy', $exercise) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-modal>
                <v-dropdown-item label="Trash"
                                 route="{{ route('admin.exercise.data.trash', $exercise) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>
        </v-dropdown>

        <v-dropdown>
            <template v-slot:label>
                Translations
            </template>

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.exercise.show', [$__language, $exercise]) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::view_translations) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>
    </v-button-group>
@endsection

@section('content')
    @if($exerciseData->count() > 0)
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Exercise {{ $exercise->index }}</h5>
                <h6 class="card-subtitle">
                    @includeWhen($exercise->isDisabled($content->language), 'admin.components.disabled.content')
                </h6>
                @include('admin.content.exercises.data.list')
            </div>
        </div>
    @endif

    @include('admin.components.modals.confirmation', ['id' => 'exercise-' . $exercise->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $exercise]), 'form' =>  'exercise-' . $exercise->id . '-delete', 'action' => 'Delete'])
@endsection
