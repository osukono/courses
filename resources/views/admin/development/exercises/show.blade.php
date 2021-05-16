@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.exercises.show', $exercise) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button id="previous" route="{{ route('admin.dev.exercises.show', $previous) }}">
                <icon-chevron-left></icon-chevron-left>
            </v-button>
        @endisset
        @isset($next)
            <v-button id="next" route="{{ route('admin.dev.exercises.show', $next) }}">
                <icon-chevron-right></icon-chevron-right>
            </v-button>
        @endisset
    </v-button-group>

    <v-button-group>
        <v-button tooltip="Add Sentence"
                  submit="#create-sentence"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
            <icon-plus></icon-plus>
            Sentence
            @push('forms')
                <form id="create-sentence" class="d-none" action="{{ route('admin.dev.exercise.data.create', $exercise) }}"
                      method="post" autocomplete="off">
                    @csrf
                </form>
            @endpush
        </v-button>

        <v-dropdown>
            <template v-slot:label>
                Translation
            </template>

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.exercises.show', [$__language, $exercise]) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::view_translations) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

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
                              action="{{ route('admin.dev.exercises.' . ($exercise->isDisabled($content->language) ? 'enable' : 'disable'), $exercise) }}"
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
                        <form class="d-none" id="exercise-{{ $exercise->id }}-delete" action="{{ route('admin.dev.exercises.destroy', $exercise) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-modal>
                <v-dropdown-item label="Trash"
                                 route="{{ route('admin.dev.exercise.data.trash', $exercise) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>
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
                @include('admin.development.exercises.data.list')
            </div>
        </div>
    @endif

    @include('admin.components.modals.confirmation', ['id' => 'exercise-' . $exercise->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $exercise]), 'form' =>  'exercise-' . $exercise->id . '-delete', 'action' => 'Delete'])
@endsection
