@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.lessons.show', $lesson) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button id="previous" route="{{ route('admin.dev.lessons.show', $previous) }}">
                <icon-chevron-left></icon-chevron-left>
            </v-button>
        @endisset
        @isset($next)
            <v-button id="next" route="{{ route('admin.dev.lessons.show', $next) }}">
                <icon-chevron-right></icon-chevron-right>
            </v-button>
        @endisset
    </v-button-group>

    <v-button-group>
        <v-button tooltip="{{ __('admin.menu.create.exercise') }}"
                  submit="#create-exercise"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
            <icon-plus></icon-plus>
            Exercise
            @push('forms')
                <form id="create-exercise" class="d-none" action="{{ route('admin.dev.exercises.store', $lesson) }}"
                      method="post">
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
                                 route="{{ route('admin.translations.lessons.show', [$__language, $lesson]) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::view_translations) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

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
                              action="{{ route('admin.dev.lessons.' . ($lesson->isDisabled($content->language) ? 'enable' : 'disable'), $lesson) }}"
                              method="post">
                            @method('patch')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-item>
                <v-dropdown-item label="Properties"
                                 route="{{ route('admin.dev.lessons.edit', $lesson) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
                @isset($image)
                    <v-dropdown-modal label="Delete Image"
                                      modal="lesson-{{ $lesson->id }}-image-modal-delete"
                                      visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                        @push('forms')
                            <form class="d-none"
                                  id="lesson-{{ $lesson->id }}-image-delete"
                                  action="{{ route('admin.dev.lessons.image.delete', [$lesson, $content->language]) }}"
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
                              action="{{ route('admin.dev.lessons.destroy', $lesson) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-modal>
                <v-dropdown-item label="Trash"
                                 route="{{ route('admin.dev.exercises.trash', $lesson) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>
        </v-dropdown>
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
                             @can(\App\Library\Permissions::update_content)
                             onclick="$('#lesson-{{ $lesson->id }}-image').click();" style="cursor: pointer;"
                            @endcan
                        >
                    @else
                        <div class="text-center border rounded bg-white align-middle d-table-cell"
                             style="width: 208px; height: 117px;">
                            @can(\App\Library\Permissions::update_content)
                                <button type="button" class="btn btn-info btn-sm"
                                        onclick="$('#lesson-{{ $lesson->id }}-image').click();">
                                    Upload Image
                                </button>
                            @endcan
                        </div>
                    @endisset
                    @can(\App\Library\Permissions::update_content)
                            <form class="d-none" id="lesson-{{ $lesson->id }}-upload-image"
                                  action="{{ route('admin.dev.lessons.image.upload', [$lesson, $content->language]) }}"
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
                    <h5 class="card-title">{{ $lesson->title }}</h5>
                    <h6 class="card-subtitle">
                        @includeWhen($lesson->isDisabled($content->language), 'admin.components.disabled.content')
                    </h6>
                    <div class="p-3 mt-3"
                         @can(\App\Library\Permissions::update_content)
                         style="cursor: pointer" onclick="window.location='{{ route('admin.dev.lessons.grammar.edit', $lesson) }}'; return null"
                         @endcan
                    >
                        @isset($grammar_point)
                            {!! $grammar_point !!}
                        @else
                            @can(\App\Library\Permissions::update_content)
                            <div class="btn btn-sm btn-info">Grammar Point</div>
                            @endcan
                        @endempty
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($exercises->count())
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                @include('admin.development.exercises.list')
            </div>
        </div>
    @endif

    @include('admin.components.modals.confirmation', ['id' => 'lesson-' . $lesson->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $lesson]), 'form' =>  'lesson-' . $lesson->id . '-delete', 'action' => 'Delete'])
    @include('admin.components.modals.confirmation', ['id' => 'lesson-' . $lesson->id . '-image-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $lesson->title . ' image']), 'form' =>  'lesson-' . $lesson->id . '-image-delete', 'action' => 'Delete'])
@endsection
