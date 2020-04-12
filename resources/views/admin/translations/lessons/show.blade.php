@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.lesson.show', $language, $lesson) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button id="previous" route="{{ route('admin.translations.lesson.show', [$language, $previous]) }}">
                <template v-slot:icon>
                    <icon-chevron-left></icon-chevron-left>
                </template>
            </v-button>
        @endisset
        @isset($next)
            <v-button id="next" route="{{ route('admin.translations.lesson.show', [$language, $next]) }}">
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
                <v-dropdown-item label="{{ $lesson->isDisabled($language) ? 'Enable' : 'Disable' }}"
                                 submit="#lesson-{{ $lesson->id }}-{{ $lesson->isDisabled($language) ? 'enable' : 'disable' }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_translations) }}">
                    @push('forms')
                        <form class="d-none"
                              id="lesson-{{ $lesson->id }}-{{ $lesson->isDisabled($language) ? 'enable' : 'disable' }}"
                              action="{{ route('admin.translations.lesson.' . ($lesson->isDisabled($language) ? 'enable' : 'disable'), [$language, $lesson]) }}"
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
                                 route="{{ route('admin.translations.lesson.show', [$__language, $lesson]) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

        <v-button route="{{ route('admin.lessons.show', $lesson) }}"
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
    @if($exercises->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $lesson->title . ' › ' . $language->native }}</h5>
                @if($lesson->isDisabled($content->language) or $lesson->isDisabled($language))
                    <h6 class="card-subtitle">
                        @if($lesson->isDisabled($content->language))
                            <span class="badge badge-warning text-uppercase">Disabled</span>
                        @endif
                        @if($lesson->isDisabled($language))
                            <span class="badge badge-light text-uppercase">Disabled</span>
                        @endif
                    </h6>
                @endif
                @include('admin.translations.exercises.list')
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @include('admin.components.audio.player')
@endpush
