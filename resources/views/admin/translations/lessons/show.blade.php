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
                <div class="row">
                    <div class="col-auto">
                        @isset($image)
                            <img width="208" height="117" class="rounded" src="{{ $image->image }}"
                                 alt="Course Image"
                                 onclick="$('#lesson-{{ $lesson->id }}-image').click();" style="cursor: pointer;">
                        @else
                            <div class="text-center border rounded bg-white align-middle d-table-cell"
                                 style="width: 208px; height: 117px;">
                                <button type="button" class="btn btn-info btn-sm"
                                        onclick="$('#lesson-{{ $lesson->id }}-image').click();">
                                    Upload Image
                                </button>
                            </div>
                        @endisset
                        <form class="d-none" id="lesson-{{ $lesson->id }}-upload-image"
                              action="{{ route('admin.lessons.image.upload', [$lesson, $language]) }}"
                              method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <input type="file" id="lesson-{{ $lesson->id }}-image" name="image" accept="image/svg+xml"
                                   onchange="$('#lesson-{{ $lesson->id }}-upload-image').submit();">
                        </form>
                    </div>
                    <div class="col">
                        <h5 class="card-title">{{ $lesson->title . ' › ' . $language->native }}</h5>
                        <h6 class="card-subtitle">
                            @includeWhen($lesson->isDisabled($content->language), 'admin.components.disabled.content')
                            @includeWhen($lesson->isDisabled($language), 'admin.components.disabled.translation')
                        </h6>
                    </div>
                </div>

                @include('admin.translations.exercises.list')
            </div>
        </div>
    @endif
@endsection
