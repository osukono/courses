@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.show', $content) }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="{{ __('admin.menu.create.lesson') }}"
                  route="{{ route('admin.lessons.create', $content) }}"
                  visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
            <template v-slot:icon>
                <icon-plus></icon-plus>
            </template>
        </v-button>

        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>

            <v-dropdown-group>
                <v-dropdown-item label="Content Editors"
                                 route="{{ route('admin.content.editors.index', $content) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::assign_editors) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="Download">
                <v-dropdown-item label="{{ $content->language }}"
                                 route="{{ route('admin.content.export', $content) }}">
                </v-dropdown-item>
                <v-dropdown-item label="Content"
                                 route="{{ route('admin.content.export.json', $content) }}"
                                 visible="{{ Auth::getUser()->hasRole(\App\Library\Roles::admin) }}">

                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="Import">
                <v-dropdown-item label="Content"
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

            <v-dropdown-group>
                <v-dropdown-item label="Properties"
                                 route="{{ route('admin.content.edit', $content) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
                <v-dropdown-item label="Speech Settings"
                                 route="{{ route('admin.content.speech.settings.edit', $content) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-confirmation label="Delete Content"
                                         title="{{ __('admin.form.delete_confirmation', ['object' => $content]) }}"
                                         btn-ok-label="{{ __('admin.form.delete') }}"
                                         form="content-{{ $content->id }}-delete"
                                         visible="{{ Auth::getUser()->can(\App\Library\Permissions::delete_content) }}">
                    @push('forms')
                        <form class="d-none" id="content-{{ $content->id }}-delete"
                              action="{{ route('admin.content.destroy', $content) }}"
                              method="post">
                            @method('delete')
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-confirmation>
                <v-dropdown-item label="Trash"
                                 route="{{ route('admin.lessons.trash', $content) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::restore_content) }}">
                </v-dropdown-item>
            </v-dropdown-group>
        </v-dropdown>

        <v-dropdown>
            <template v-slot:label>
                Translations
            </template>

            @foreach($languages as $language)
                <v-dropdown-item label="{{ $language->native }}"
                                 route="{{ route('admin.translations.content.show', [$language, $content]) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::view_translations) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>
    </v-button-group>
@endsection

@section('content')
    <div class="card mb-4" style="cursor: pointer"
         onclick="window.location.href='{{ route('admin.content.edit', $content) }}';">
        <div class="card-body">
            @isset($content->title)
                <h5 class="card-title">{{ $content->title }}</h5>
                <p class="card-text">{!! nl2br(e($content->description)) !!}</p>
            @else
                <h5 class="card-title text-muted">Title</h5>
                <p class="card-text text-muted">Description</p>
            @endisset
        </div>
    </div>

    @if($lessons->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">@include('admin.content.title')</h5>
                @include('admin.content.lessons.list')
            </div>
        </div>
    @endif

    @if (Session::has('job'))
        @push('progress')
            <job-status job-id="{{ Session::get('job') }}"
                        job-status-url="{{ route('admin.jobs.status', Session::get('job')) }}"
                        redirect-url="{{ route('admin.content.show', $content) }}"
            ></job-status>
        @endpush
    @endif
@endsection
