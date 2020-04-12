@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.exercise.show', $language, $exercise) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button id="previous" route="{{ route('admin.translations.exercise.show', [$language, $previous]) }}">
                <template v-slot:icon>
                    <icon-chevron-left></icon-chevron-left>
                </template>
            </v-button>
        @endisset
        @isset($next)
            <v-button id="next" route="{{ route('admin.translations.exercise.show', [$language, $next]) }}">
                <template v-slot:icon>
                    <icon-chevron-right></icon-chevron-right>
                </template>
            </v-button>
        @endisset
    </v-button-group>

    <v-button-group>
        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>

            <v-dropdown-group>
                <v-dropdown-item label="{{ $exercise->isDisabled($language) ? 'Enable' : 'Disable' }}"
                                 submit="#exercise-{{ $exercise->id }}-{{ $exercise->isDisabled($language) ? 'enable' : 'disable' }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_translations) }}">
                    @push('forms')
                        <form class="d-none"
                              id="exercise-{{ $exercise->id }}-{{ $exercise->isDisabled($language) ? 'enable' : 'disable' }}"
                              action="{{ route('admin.translations.exercise.' . ($exercise->isDisabled($language) ? 'enable' : 'disable'), [$language, $exercise]) }}"
                              method="post">
                            @method('patch')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-item>
            </v-dropdown-group>
        </v-dropdown>

        <v-dropdown>
            <template v-slot:label>
                Translations
            </template>

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.exercise.show', [$__language, $exercise]) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

        <v-button route="{{ route('admin.exercises.show', $exercise) }}"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::view_content) }}">
            <template v-slot:label>
                Content
            </template>
            <template v-slot:icon>
                <icon-chevron-right></icon-chevron-right>
            </template>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if($exerciseData->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Exercise {{ $exercise->index . ' › ' . $language->native }}</h5>
                @if($exercise->isDisabled($content->language) or $exercise->isDisabled($language))
                    <h6 class="card-subtitle">
                        @if($exercise->isDisabled($content->language))
                            <span class="badge badge-warning text-uppercase">Disabled</span>
                        @endif
                        @if($exercise->isDisabled($language))
                            <span class="badge badge-light text-uppercase">Disabled</span>
                        @endif
                    </h6>
                @endif
                @include('admin.translations.exercises.data.list')
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @include('admin.components.audio.player')
@endpush
