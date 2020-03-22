@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.show', $content) }}
@endsection

@section('toolbar')
    <div class="btn-group ml-2" role="group">
        @includeWhen(Auth::getUser()->can(\App\Library\Permissions::update_content), 'admin.components.menu.create', ['route' => route('admin.lessons.create', $content), 'title' => __('admin.menu.create.lesson')])
        <div class="btn-group" role="group">
            <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                @include('admin.components.svg.more-vertical')
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
                @can(\App\Library\Permissions::assign_editors)
                    <a class="dropdown-item" href="{{ route('admin.content.editors.index', $content) }}">
                        Content Editors
                    </a>
                    <div class="dropdown-divider"></div>
                @endcan

                <h6 class="dropdown-header">Download</h6>
                <a class="dropdown-item" href="{{ route('admin.content.export', $content) }}">
                    {{ $content->language }}
                </a>
                @role(\App\Library\Roles::admin)
                <a class="dropdown-item" href="{{ route('admin.content.export.json', $content) }}">Content</a>
                @endrole

                @role(\App\Library\Roles::admin)
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">Import</h6>
                <button type="button" class="dropdown-item" onclick="$('#content-{{ $content->id }}-json').click();">
                    Content
                </button>
                <form class="d-none" id="content-{{ $content->id }}-import"
                      action="{{ route('admin.content.import.json', $content) }}"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="file" id="content-{{ $content->id }}-json" name="json" accept="application/json"
                           onchange="$('#content-{{ $content->id }}-import').submit();">
                </form>
                @endrole

                @can(\App\Library\Permissions::update_content)
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.content.edit', $content) }}">Properties</a>
                    <a class="dropdown-item" href="{{ route('admin.content.speech.settings.edit', $content) }}">Speech Settings</a>
                @endcan

                @can(\App\Library\Permissions::delete_content)
                    <div class="dropdown-divider"></div>
                    <form class="d-none" id="content-{{ $content->id }}-delete"
                          action="{{ route('admin.content.destroy', $content) }}"
                          method="post">
                        @method('delete')
                        @csrf
                    </form>
                    <button class="dropdown-item text-danger" type="button"
                            data-toggle="confirmation"
                            data-btn-ok-label="{{ __('admin.form.delete') }}"
                            data-title="{{ __('admin.form.delete_confirmation', ['object' => $content]) }}"
                            data-form="content-{{ $content->id }}-delete">
                        Delete Content
                    </button>
                @endcan
                @can(\App\Library\Permissions::restore_content)
                    <a class="dropdown-item" href="{{ route('admin.lessons.trash', $content) }}">Trash</a>
                @endcan
            </div>
        </div>

        @can(\App\Library\Permissions::view_translations && $languages->isNotEmpty())
            @include('admin.components.menu.translations', ['route' => 'admin.translations.content.show', 'arg' => $content])
        @endcan
    </div>
@endsection

@section('content')
    <div class="card mb-4" style="cursor: pointer"
         onclick="window.location.href='{{ route('admin.content.edit', $content) }}';">
        <div class="card-body">
            @isset($content->title)
                <h5 class="card-title">{{ $content->title }}</h5>
                <p class="card-text">{{ $content->description }}</p>
            @else
                <h5 class="card-title text-muted">Title</h5>
                <p class="card-text text-muted">Description</p>
            @endisset
        </div>
    </div>

    @if($lessons->count())
        <div class="card">
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
