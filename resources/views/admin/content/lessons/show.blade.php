@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.lessons.show', $lesson) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button id="previous" route="{{ route('admin.lessons.show', $previous) }}">
                <template v-slot:icon>
                    <icon-chevron-left></icon-chevron-left>
                </template>
            </v-button>
        @endisset
        @isset($next)
            <v-button id="next" route="{{ route('admin.lessons.show', $next) }}">
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
            <template v-slot:label>
                Exercise
            </template>
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
                @isset($image)
                    <v-dropdown-modal label="Delete Image"
                                     modal="lesson-{{ $lesson->id }}-image-modal-delete"
                                     visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                        @push('forms')
                            <form class="d-none"
                                  id="lesson-{{ $lesson->id }}-image-delete"
                                  action="{{ route('admin.lessons.image.delete', [$lesson, $content->language]) }}"
                                  method="post">
                                @method('delete')
                                @csrf
                            </form>
                        @endpush
                    </v-dropdown-modal>
                @endisset
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-modal label="Delete Lesson"
                                  modal="lesson-{{ $lesson->id }}-modal-delete"
                                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                    @push('forms')
                        <form class="d-none" id="lesson-{{ $lesson->id }}-delete"
                              action="{{ route('admin.lessons.destroy', $lesson) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-modal>
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

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.lesson.show', [$__language, $lesson]) }}"
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
                <div class="row">
                    @can(\App\Library\Permissions::update_content)
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
                                  action="{{ route('admin.lessons.image.upload', [$lesson, $content->language]) }}"
                                  method="post" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <input type="file" id="lesson-{{ $lesson->id }}-image" name="image"
                                       accept="image/svg+xml"
                                       onchange="$('#lesson-{{ $lesson->id }}-upload-image').submit();">
                            </form>
                        </div>
                    @endcan
                    <div class="col">
                        <h5 class="card-title">{{ $lesson->title }}</h5>
                        <h6 class="card-subtitle">
                            @includeWhen($lesson->isDisabled($content->language), 'admin.components.disabled.content')
                        </h6>
                    </div>
                </div>
                @include('admin.content.exercises.list')
            </div>
        </div>
    @endif

    @include('admin.components.modals.confirmation', ['id' => 'lesson-' . $lesson->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $lesson]), 'form' =>  'lesson-' . $lesson->id . '-delete', 'action' => 'Delete'])
    @include('admin.components.modals.confirmation', ['id' => 'lesson-' . $lesson->id . '-image-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $lesson->title . ' image']), 'form' =>  'lesson-' . $lesson->id . '-image-delete', 'action' => 'Delete'])
@endsection
