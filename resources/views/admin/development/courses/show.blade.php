@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.courses.show', $content) }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="{{ __('admin.dev.lessons.toolbar.create') }}"
                  route="{{ route('admin.dev.lessons.create', $content) }}"
                  enabled="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
            {{ __('admin.dev.lessons.toolbar.create') }}
        </v-button>

        <v-dropdown>
            <template v-slot:label>
                {{ __('admin.dev.lessons.toolbar.translations') }}
            </template>

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.show', [$__language, $content]) }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::view_translations) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>

            <v-dropdown-group>
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.editors') }}"
                                 route="{{ route('admin.dev.courses.editors.index', $content) }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::assign_editors) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="{{ __('admin.dev.lessons.toolbar.more.export.title') }}">
                <v-dropdown-item label="{{ $content->language->native}}"
                                 route="{{ route('admin.dev.courses.export', $content) }}">
                </v-dropdown-item>
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.export.backup') }}"
                                 route="{{ route('admin.dev.courses.export.json', $content) }}"
                                 enabled="{{ Auth::getUser()->hasRole(\App\Library\Roles::admin) }}">

                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="{{ __('admin.dev.lessons.toolbar.more.import.title') }}">
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.import.backup') }}"
                                 click="#content-{{ $content->id }}-import-json"
                                 enabled="{{ Auth::getUser()->hasRole(\App\Library\Roles::admin) }}">
                    @push('forms')
                        <form class="d-none" id="content-{{ $content->id }}-import-form"
                              action="{{ route('admin.dev.courses.import.json', $content) }}"
                              method="post" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <input type="file" id="content-{{ $content->id }}-import-json" name="json"
                                   accept="application/json"
                                   onchange="$('#content-{{ $content->id }}-import-form').submit();">
                        </form>
                    @endpush
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="{{ __('admin.dev.lessons.toolbar.more.properties.title') }}">
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.properties.course') }}"
                                 route="{{ route('admin.dev.courses.edit', $content) }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.properties.speech') }}"
                                 route="{{ route('admin.content.speech.settings.edit', $content) }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-modal label="Synthesize Audio"
                                  modal="content-{{ $content->id }}-modal-synthesize"
                                  visiable="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                    @push('forms')
                        <form class="d-none" id="content-{{ $content->id }}-synthesize"
                              action="{{ route('admin.dev.courses.audio.synthesize', $content) }}"
                              method="post">
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-modal>
                <v-dropdown-modal label="{{ __('admin.dev.lessons.toolbar.more.delete') }}"
                                  modal="content-{{ $content->id }}-modal-delete"
                                  enabled="{{ Auth::getUser()->can(\App\Library\Permissions::delete_content) }}">
                    @push('forms')
                        <form class="d-none" id="content-{{ $content->id }}-delete"
                              action="{{ route('admin.dev.courses.destroy', $content) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-modal>
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.trash') }}"
                                 route="{{ route('admin.dev.lessons.trash', $content) }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::restore_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>
        </v-dropdown>
    </v-button-group>
@endsection

@section('content')
    @if($lessons->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">{{ $content->language->native . ' › ' . $content->level->name }}</h5>
                @include('admin.development.lessons.list')
            </div>
        </div>
    @endif

    @include('admin.components.modals.confirmation', ['id' => 'content-' . $content->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $content]), 'form' =>  'content-' . $content->id . '-delete', 'action' => 'Delete'])
    @include('admin.components.modals.confirmation', ['id' => 'content-' . $content->id . '-modal-synthesize', 'title' => 'Do you want to synthesize the audio for ' . $content . '?', 'form' =>  'content-' . $content->id . '-synthesize', 'action' => 'Synthesize'])
@endsection
