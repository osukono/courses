@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.lessons.show', $lesson) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button route="{{ route('admin.lessons.show', $previous) }}">
                <template v-slot:icon>
                    <icon-chevron-left></icon-chevron-left>
                </template>
            </v-button>
        @endisset
        @isset($next)
            <v-button route="{{ route('admin.lessons.show', $next) }}">
                <template v-slot:icon>
                    <icon-chevron-right></icon-chevron-right>
                </template>
            </v-button>
        @endisset
    </v-button-group>

    <v-button-group>
        <v-button tooltip="{{ __('admin.menu.create.exercise') }}"
                  submit="#create-exercise"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
            <template v-slot:icon>
                <icon-plus></icon-plus>
            </template>
            @push('forms')
                <form id="create-exercise" class="d-none" action="{{ route('admin.exercises.store', $lesson) }}"
                      method="post">
                    @csrf
                </form>
            @endpush
        </v-button>

        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>

            <v-dropdown-group>
                <v-dropdown-item label="{{ ($lesson->isDisabled($content->language)) ? 'Enable' : 'Disable' }}"
                                 submit="#lesson-{{ $lesson->id }}-{{ ($lesson->isDisabled($content->language) ? 'enable' : 'disable') }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                    @push('forms')
                        <form class="d-none"
                              id="lesson-{{ $lesson->id }}-{{ ($lesson->isDisabled($content->language) ? 'enable' : 'disable') }}"
                              action="{{ route('admin.lessons.' . ($lesson->isDisabled($content->language) ? 'enable' : 'disable'), $lesson) }}"
                              method="post">
                            @method('patch')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-item>
                <v-dropdown-item label="Properties"
                                 route="{{ route('admin.lessons.edit', $lesson) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-confirmation label="Delete Lesson"
                                         title="{{ __('admin.form.delete_confirmation', ['object' => $lesson]) }}"
                                         btn-ok-label="{{ __('admin.form.delete') }}"
                                         form="#lesson-{{ $lesson->id }}-delete"
                                         visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                    @push('forms')
                        <form class="d-none" id="lesson-{{ $lesson->id }}-delete"
                              action="{{ route('admin.lessons.destroy', $lesson) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-confirmation>
                <v-dropdown-item label="Trash"
                                 route="{{ route('admin.exercises.trash', $lesson) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>
        </v-dropdown>

        <v-dropdown>
            <template v-slot:label>
                Translations
            </template>

            @foreach($languages as $language)
                <v-dropdown-item label="{{ $language->native }}"
                                 route="{{ route('admin.translations.lesson.show', [$language, $lesson]) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::view_translations) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>
    </v-button-group>
@endsection

@section('content')
    @if($exercises->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    @include('admin.content.title')
                </h5>
                @if($lesson->isDisabled($content->language))
                    <h6 class="card-subtitle"><span class="badge badge-warning text-uppercase">Disabled</span></h6>
                @endif
                @include('admin.content.exercises.list')
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @include('admin.components.audio.player')
@endpush
