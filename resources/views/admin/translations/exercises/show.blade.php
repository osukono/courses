@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.exercise.show', $language, $exercise) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button id="previous" route="{{ route('admin.translations.exercise.show', [$language, $previous]) }}">
                <icon-chevron-left></icon-chevron-left>
            </v-button>
        @endisset
        @isset($next)
            <v-button id="next" route="{{ route('admin.translations.exercise.show', [$language, $next]) }}">
                <icon-chevron-right></icon-chevron-right>
            </v-button>
        @endisset
    </v-button-group>

    <v-button-group>
        <v-dropdown visible="{{ $languages->isNotEmpty() }}">
            <template v-slot:label>
                {{ $language->native }}
            </template>

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.exercise.show', [$__language, $exercise]) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

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

        <v-button route="{{ route('admin.exercises.show', $exercise) }}"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::view_content) }}">
            {{ $content->language->native }}
            <icon-chevron-right></icon-chevron-right>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if($exerciseData->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Exercise {{ $exercise->index . ' › ' . $language->native }}</h5>
                <h6 class="card-subtitle">
                    @includeWhen($exercise->isDisabled($content->language), 'admin.components.disabled.content')
                    @includeWhen($exercise->isDisabled($language), 'admin.components.disabled.translation')
                </h6>
                @include('admin.translations.exercises.data.list')
            </div>
        </div>
    @endif
@endsection
