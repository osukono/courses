<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('favicon-16x16.png') }}">

    <link href="{{ mix('css/admin_3x0xof.css') }}" rel="stylesheet">
    <script src="{{ mix('js/admin_3x0xof.js') }}"></script>
    <script src="{{ mix('js/admin_vue_3x0xof.js') }}" defer></script>
</head>
<body>
<div id="app" class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header text-center mt-2">
            <a href="{{ route('welcome') }}"><h3 class="brand">Yummy Lingo</h3></a>
            <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::profile) }}" href="{{ route('admin.profile') }}">{{ Auth::getUser()->name }}</a>
        </div>

        <ul class="list-unstyled">
            <p>{{ __('admin.menu.console.header') }}</p>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::dashboard) }}"
                   href="{{ route('admin.dashboard') }}">
                    <icon-activity></icon-activity>
                    <div class="link">{{ __('admin.menu.dashboard') }}</div>
                </a>
            </li>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::users) }}"
                   href="{{ route('admin.users.index') }}">
                    <icon-users></icon-users>
                    <div class="link">{{ __('admin.menu.console.users') }}</div>
                </a>
            </li>
        </ul>

        <ul class="list-unstyled">
            <p>{{ __('admin.menu.courses.header') }}</p>
            @can(\App\Library\Permissions::view_content)
                <li>
                    <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::content) }}"
                       href="{{ route('admin.content.index') }}">
                        <icon-book-open></icon-book-open>
                        <div class="link">{{ __('admin.menu.courses.development') }}</div>
                    </a>
                </li>
            @endcan
            @can(\App\Library\Permissions::view_courses)
                <li>
                    <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::courses) }}"
                       href="{{ route('admin.courses.index') }}">
                        <icon-book></icon-book>
                        <div class="link">{{ __('admin.menu.courses.production') }}</div>
                    </a>
                </li>
            @endcan
        </ul>
        @role(\App\Library\Roles::admin)
        <ul class="list-unstyled">
            <p>{{ __('admin.menu.app.header') }}</p>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::languages) }}"
                   href="{{ route('admin.languages.index') }}">
                    <icon-globe></icon-globe>
                    <div class="link">{{ __('admin.menu.app.languages') }}</div>
                </a>
            </li>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::topics) }}"
                   href="{{ route('admin.topics.index') }}">
                    <icon-message-square></icon-message-square>
                    <div class="link">{{ __('admin.menu.app.topics') }}</div>
                </a>
            </li>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::locales) }}"
                   href="{{ route('admin.app.locales.index') }}">
                    <icon-list></icon-list>
                    <div class="link">{{ __('admin.menu.app.localization') }}</div>
                </a>
            </li>
        </ul>
        @endrole
    </nav>

    <div class="container-fluid pb-3">
        <div id="content" class="pt-0">
            <main role="main" class="">
                <div class="row bg-white border-bottom pt-3 pb-3 mb-3" style="min-height: 70px">
                    <nav class="navbar navbar-expand-md bg-white navbar-light d-md-none pr-0 py-0">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" id="sidebarCollapse" data-target="#sidebar">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                    </nav>
                    <div class="col text-nowrap align-self-center">
                        @yield('breadcrumbs')
                    </div>
                    <div id="toolbar" class="text-right pt-3 pt-md-0 col-12 col-md-auto">
                        @yield('toolbar')
                    </div>
                </div>
                @if (Session::has('job-id'))
                    <job-status job-id="{{ Session::get('job-id') }}"
                                job-status-url="{{ route('admin.jobs.status', Session::get('job-id')) }}"
                                redirect-url="{{ Session::get('job-redirect-url') }}"
                    ></job-status>
                @endif
                @if(session()->has('message') or session()->has('error'))
                    <div class="row">
                        <div class="col">
                            @include('admin.components.messages')
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col mt-2">
                        @yield('content')
                        @stack('forms')
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
@stack('scripts')
@include('admin.components.audio.player')
</body>
</html>
