@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.show', $content) }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="{{ __('admin.dev.lessons.toolbar.create') }}"
                  route="{{ route('admin.lessons.create', $content) }}"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
            <template v-slot:label>
                {{ __('admin.dev.lessons.toolbar.create') }}
            </template>
        </v-button>

        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>

            <v-dropdown-group>
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.editors') }}"
                                 route="{{ route('admin.content.editors.index', $content) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::assign_editors) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="{{ __('admin.dev.lessons.toolbar.more.export.title') }}">
                <v-dropdown-item label="{{ $content->language . ' TXT' }}"
                                 route="{{ route('admin.content.export', $content) }}">
                </v-dropdown-item>
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.export.backup') }}"
                                 route="{{ route('admin.content.export.json', $content) }}"
                                 visible="{{ Auth::getUser()->hasRole(\App\Library\Roles::admin) }}">

                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="{{ __('admin.dev.lessons.toolbar.more.import.title') }}">
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.import.backup') }}"
                                 click="#content-{{ $content->id }}-import-json"
                                 visible="{{ Auth::getUser()->hasRole(\App\Library\Roles::admin) }}">
                    @push('forms')
                        <form class="d-none" id="content-{{ $content->id }}-import-form"
                              action="{{ route('admin.content.import.json', $content) }}"
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
                                 route="{{ route('admin.content.edit', $content) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.properties.speech') }}"
                                 route="{{ route('admin.content.speech.settings.edit', $content) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-modal label="{{ __('admin.dev.lessons.toolbar.more.delete') }}"
                                  modal="content-{{ $content->id }}-modal-delete"
                                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::delete_content) }}">
                    @push('forms')
                        <form class="d-none" id="content-{{ $content->id }}-delete"
                              action="{{ route('admin.content.destroy', $content) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-modal>
                <v-dropdown-item label="{{ __('admin.dev.lessons.toolbar.more.trash') }}"
                                 route="{{ route('admin.lessons.trash', $content) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::restore_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>
        </v-dropdown>

        <v-dropdown>
            <template v-slot:label>
                {{ __('admin.dev.lessons.toolbar.translations') }}
            </template>

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.content.show', [$__language, $content]) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::view_translations) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>
    </v-button-group>
@endsection

@section('content')
    @if($lessons->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">{{ $content->language->native . ' › ' . $content->level->name }}</h5>
                @include('admin.content.lessons.list')
            </div>
        </div>
    @endif

    @include('admin.components.modals.confirmation', ['id' => 'content-' . $content->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $content]), 'form' =>  'content-' . $content->id . '-delete', 'action' => 'Delete'])
@endsection
