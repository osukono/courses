@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.content.show', $language, $content) }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>
            <v-dropdown-group>
                <v-dropdown-item label="Translation Editors"
                                 route="{{ route('admin.translations.editors.index', [$language, $content]) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::assign_editors) }}">

                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="Download">
                <v-dropdown-item label="{{ $language->native }}"
                                 route="{{ route('admin.translations.content.export', [$language, $content]) }}">
                </v-dropdown-item>
                <v-dropdown-item label="{{ $content->language->native . ' + ' . $language->native }}"
                                 route="{{ route('admin.translations.content.export', [$language, $content]) }}?target=1">

                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-item label="Speech Settings"
                                 route="{{ route('admin.translations.speech.settings.edit', [$language, $content]) }}"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::update_translations) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-item label="Commit"
                                 sumbit="#commit"
                                 visible="{{ Auth::getUser()->can(\App\Library\Permissions::publish_courses) }}">
                    @push('forms')
                        <form class="d-none" id="commit"
                              action="{{ route('admin.translations.commit', [$language, $content]) }}"
                              method="post">
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

            @foreach($languages as $language)
                <v-dropdown-item label="{{ $language->native }}"
                                 route="{{ route('admin.translations.content.show', [$language, $content]) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

        <v-button route="{{ route('admin.content.show', $content) }}">
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
    @if($lessons->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">@include('admin.translations.title')</h5>
                @include('admin.translations.lessons.list')
            </div>
        </div>
    @endif

    @if (Session::has('job'))
        @push('progress')
            <job-status job-id="{{ Session::get('job') }}"
                        job-status-url="{{ route('admin.jobs.status', Session::get('job')) }}"
            ></job-status>
        @endpush
    @endif
@endsection
