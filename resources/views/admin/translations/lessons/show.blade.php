@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.lessons.show', $language, $lesson) }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button id="previous"
                  @isset($previous)
                  route="{{ route('admin.translations.lessons.show', [$language, $previous]) }}"
                  @endisset
                  enabled="{{ isset($previous) }}">
            <icon-chevron-left></icon-chevron-left>
        </v-button>
        <v-button id="next"
                  @isset($next)
                  route="{{ route('admin.translations.lessons.show', [$language, $next]) }}"
                  @endisset
                  enabled="{{ isset($next) }}">
            <icon-chevron-right></icon-chevron-right>
        </v-button>
    </v-button-group>

    <v-button-group>
        <v-dropdown enabled="{{ $languages->isNotEmpty() }}">
            <template v-slot:label>
                {{ $language->native }}
            </template>

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.lessons.show', [$__language, $lesson]) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>

            <v-dropdown-group>
                <v-dropdown-item label="{{ $lesson->isDisabled($language) ? 'Enable' : 'Disable' }}"
                                 submit="#lesson-{{ $lesson->id }}-{{ $lesson->isDisabled($language) ? 'enable' : 'disable' }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::update_translations) }}">
                    @push('forms')
                        <form class="d-none"
                              id="lesson-{{ $lesson->id }}-{{ $lesson->isDisabled($language) ? 'enable' : 'disable' }}"
                              action="{{ route('admin.translations.lessons.' . ($lesson->isDisabled($language) ? 'enable' : 'disable'), [$language, $lesson]) }}"
                              method="post">
                            @method('patch')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-item>
                @isset($image)
                    <v-dropdown-modal label="Delete Image"
                                      modal="lesson-{{ $lesson->id }}-image-modal-delete"
                                      enabled="{{ Auth::getUser()->can(\App\Library\Permissions::update_translations) }}">
                        @push('forms')
                            <form class="d-none"
                                  id="lesson-{{ $lesson->id }}-image-delete"
                                  action="{{ route('admin.dev.lessons.image.delete', [$lesson, $language]) }}"
                                  method="post">
                                @method('delete')
                                @csrf
                            </form>
                        @endpush
                    </v-dropdown-modal>
                @endisset
            </v-dropdown-group>
        </v-dropdown>

        <v-button route="{{ route('admin.dev.lessons.show', $lesson) }}"
                  enabled="{{ Auth::getUser()->can(\App\Library\Permissions::view_content) }}">
            {{ $content->language->native }}
            <icon-chevron-right></icon-chevron-right>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    @isset($image)
                        <img width="208" height="117" class="rounded" src="{{ $image }}"
                             alt="Course Image"
                             @can(\App\Library\Permissions::update_translations)
                             onclick="$('#lesson-{{ $lesson->id }}-image').click();" style="cursor: pointer;"
                            @endcan
                        >
                    @else
                        <div class="text-center border rounded bg-white align-middle d-table-cell"
                             style="width: 208px; height: 117px;">
                            @can(\App\Library\Permissions::update_translations)
                                <button type="button" class="btn btn-info btn-sm"
                                        onclick="$('#lesson-{{ $lesson->id }}-image').click();">
                                    Upload Image
                                </button>
                            @endcan
                        </div>
                    @endisset
                    @can(\App\Library\Permissions::update_translations)
                        <form class="d-none" id="lesson-{{ $lesson->id }}-upload-image"
                              action="{{ route('admin.dev.lessons.image.upload', [$lesson, $language]) }}"
                              method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <input type="file" id="lesson-{{ $lesson->id }}-image" name="image"
                                   accept="image/svg+xml"
                                   onchange="$('#lesson-{{ $lesson->id }}-upload-image').submit();">
                        </form>
                    @endcan
                </div>
                <div class="col">
                    <h5 class="card-title">{{ $lesson->title . ' › ' . $language->native }}</h5>
                    <h6 class="card-subtitle">
                        @includeWhen($lesson->isDisabled($content->language), 'admin.components.disabled.content')
                        @includeWhen($lesson->isDisabled($language), 'admin.components.disabled.translation')
                        @can(\App\Library\Permissions::update_translations)
                            @empty($description)
                                <div class="btn btn-sm btn-link"
                                     onclick="window.location='{{ route('admin.translations.lesson.description.edit', [$language, $lesson]) }}'; return null">
                                    Description
                                </div>
                            @endempty
                            @empty($grammar_point)
                                <div class="btn btn-sm btn-link"
                                     onclick="window.location='{{ route('admin.translations.lesson.grammar.edit', [$language, $lesson]) }}'; return null">
                                    Grammar Point
                                </div>
                            @endempty
                        @endcan
                    </h6>
                    @isset($description)
                        <div class="p-3 mt-3"
                             @can(\App\Library\Permissions::update_translations)
                             style="cursor: pointer"
                             onclick="window.location='{{ route('admin.translations.lesson.description.edit', [$language, $lesson]) }}'; return null"
                            @endcan
                        >
                            {!! \App\Library\StrUtils::normalize(nl2br($description)) !!}
                        </div>
                    @endisset
                    @isset($grammar_point)
                        <hr/>
                        <div class="p-3 mt-3"
                             @can(\App\Library\Permissions::update_translations)
                             style="cursor: pointer"
                             onclick="window.location='{{ route('admin.translations.lesson.grammar.edit', [$language, $lesson]) }}'; return null"
                            @endcan
                        >
                            {!! $grammar_point !!}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    @if($exercises->count())
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="row">

                </div>

                @include('admin.translations.exercises.list')
            </div>
        </div>
    @endif

    @include('admin.components.modals.confirmation', ['id' => 'lesson-' . $lesson->id . '-image-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $lesson->title . ' › ' . $language->native . ' image']), 'form' =>  'lesson-' . $lesson->id . '-image-delete', 'action' => 'Delete'])

@endsection
