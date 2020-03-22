@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.content.show', $language, $content) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group" role="group">
            <div class="btn-group" role="group">
                <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    @include('admin.components.svg.more-vertical')
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
                    @can(\App\Library\Permissions::assign_editors)
                        <a class="dropdown-item"
                           href="{{ route('admin.translations.editors.index', [$language, $content]) }}">
                            Translation Editors
                        </a>
                        <div class="dropdown-divider"></div>
                    @endcan

                    <h6 class="dropdown-header">Download</h6>
                    <a class="dropdown-item"
                       href="{{ route('admin.translations.content.export', [$language, $content]) }}">{{ $language->native }}</a>
                    <a class="dropdown-item"
                       href="{{ route('admin.translations.content.export', [$language, $content]) }}?target=1">{{ $content->language->native . ' + ' . $language->native }}</a>

                    @can(\App\Library\Permissions::update_translations)
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                           href="{{ route('admin.translations.speech.settings.edit', [$language, $content]) }}">
                            Speech Settings
                        </a>
                    @endcan

                    @can(\App\Library\Permissions::publish_courses)
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"
                           onclick="document.getElementById('commit').submit();">Commit</a>
                        <form class="d-none" id="commit"
                              action="{{ route('admin.translations.commit', [$language, $content]) }}"
                              method="post">
                            @csrf
                        </form>
                    @endcan
                </div>
            </div>

            @can($languages->isNotEmpty())
                @include('admin.components.menu.translations', ['route' => 'admin.translations.content.show', 'arg' => $content])
            @endcan

            @can(\App\Library\Permissions::view_content)
                <a class="btn btn-info" href="{{ route('admin.content.show', $content) }}">
                    Content @include('admin.components.svg.chevron-right')
                </a>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    @includeWhen($content->descirption, 'admin.components.description', ['description' => $content->description])

    <h4 class="text-nowrap">{{ $content->language->native . ' ' . $content->level->name . ' › ' . $language->native }}</h4>

    @if($lessons->count())
        @include('admin.translations.lessons.list')
    @endif

    @if (Session::has('job'))
        @push('progress')
            <job-status job-id="{{ Session::get('job') }}"
                        job-status-url="{{ route('admin.jobs.status', Session::get('job')) }}"
            ></job-status>
        @endpush
    @endif
@endsection
