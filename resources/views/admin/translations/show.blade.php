@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.show', $language, $content) }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-dropdown enabled="{{ $languages->isNotEmpty() }}">
            <template v-slot:label>
                {{ $language->native }}
            </template>

            @foreach($languages as $__language)
                <v-dropdown-item label="{{ $__language->native }}"
                                 route="{{ route('admin.translations.show', [$__language, $content]) }}">
                </v-dropdown-item>
            @endforeach
        </v-dropdown>

        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>
            <v-dropdown-group>
                <v-dropdown-item label="{{ __('admin.dev.lessons.trans.toolbar.more.editors') }}"
                                 route="{{ route('admin.translations.editors.index', [$language, $content]) }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::assign_editors) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="{{ __('admin.dev.lessons.trans.toolbar.more.export.title') }}">
                <v-dropdown-item label="{{ $content->language->native . ' + ' . $language->native }}"
                                 route="{{ route('admin.translations.export', [$language, $content]) }}?target=1">
                </v-dropdown-item>
                <v-dropdown-item label="{{ $language->native }}"
                                 route="{{ route('admin.translations.export', [$language, $content]) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group header="{{ __('admin.dev.lessons.trans.toolbar.more.properties.title') }}">
                <v-dropdown-item label="{{ __('admin.dev.lessons.trans.toolbar.more.properties.speech') }}"
                                 route="{{ route('admin.translations.speech.settings.edit', [$language, $content]) }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::update_translations) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-modal label="Synthesize Audio"
                                  modal="content-{{ $content->id }}-language-{{ $language->id }}-modal-synthesize"
                                  visiable="{{ Auth::getUser()->can(\App\Library\Permissions::update_translations) }}">
                    @push('forms')
                        <form class="d-none" id="content-{{ $content->id }}-language-{{ $language->id }}-synthesize"
                              action="{{ route('admin.translations.course.audio.synthesize', [$content, $language]) }}"
                              method="post">
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-modal>
                <v-dropdown-item label="{{ __('admin.dev.lessons.trans.toolbar.more.commit') }}" submit="#commit"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::publish_courses) }}">
                    @push('forms')
                        <form class="d-none" id="commit"
                              action="{{ route('admin.translations.commit', [$language, $content]) }}" method="post">
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-item>
            </v-dropdown-group>
        </v-dropdown>

        <v-button route="{{ route('admin.dev.courses.show', $content) }}">
            {{ $content->language->native }}
            <icon-chevron-right></icon-chevron-right>
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if($lessons->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">{{ $content->language->native . ' › ' . $content->level->name . ' › ' . $language->native }}</h5>
                @include('admin.translations.lessons.list')
            </div>
        </div>
    @endif

    @include('admin.components.modals.confirmation', ['id' => 'content-' . $content->id . '-language-' . $language->id . '-modal-synthesize', 'title' => 'Do you want to synthesize the audio for ' . $content . ' - ' . $language . ' translation?', 'form' =>  'content-' . $content->id . '-language-' . $language->id . '-synthesize', 'action' => 'Synthesize'])
@endsection
