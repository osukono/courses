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
            <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::profile) }}"
               href="{{ route('admin.profile') }}">{{ Auth::getUser()->name }}</a>
        </div>

        <ul class="list-unstyled">
            <p>{{ __('admin.menu.console.header') }}</p>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::dashboard) }}"
                   href="{{ route('admin.dashboard') }}">
                    <icon-activity></icon-activity>
                    <div class="link ms-3">{{ __('admin.menu.console.dashboard') }}</div>
                </a>
            </li>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::users) }}"
                   href="{{ route('admin.users.index') }}">
                    <icon-users></icon-users>
                    <div class="link ms-3">{{ __('admin.menu.console.users') }}</div>
                </a>
            </li>
        </ul>

        <ul class="list-unstyled">
            <p>{{ __('admin.menu.development.header') }}</p>
            @can(\App\Library\Permissions::view_content)
                <li>
                    <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::courses) }}"
                       href="{{ route('admin.dev.courses.index') }}">
                        <icon-book-open></icon-book-open>
                        <div class="link ms-3">{{ __('admin.menu.development.courses') }}</div>
                    </a>
                </li>
            @endcan
            @can(\App\Library\Permissions::view_podcasts)
                <li>
                    <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::podcasts) }}"
                       href="{{ route('admin.dev.podcasts.index') }}">
                        <icon-radio></icon-radio>
                        <div class="link ms-3">{{ __('admin.menu.development.podcasts') }}</div>
                    </a>
                </li>
            @endcan
            @can(\App\Library\Permissions::view_courses)
                <li>
                    <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::production) }}"
                       href="{{ route('admin.courses.index') }}">
                        <icon-book></icon-book>
                        <div class="link ms-3">{{ __('admin.menu.development.production') }}</div>
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
                    <div class="link ms-3">{{ __('admin.menu.app.languages') }}</div>
                </a>
            </li>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::topics) }}"
                   href="{{ route('admin.topics.index') }}">
                    <icon-message-square></icon-message-square>
                    <div class="link ms-3">{{ __('admin.menu.app.topics') }}</div>
                </a>
            </li>
            <li>
                <a class="{{ active_menu($current ?? null, \App\Library\Sidebar::locales) }}"
                   href="{{ route('admin.app.locales.index') }}">
                    <icon-list></icon-list>
                    <div class="link ms-3">{{ __('admin.menu.app.localization') }}</div>
                </a>
            </li>
        </ul>
        @endrole
        {{--        <ul class="list-unstyled">--}}
        {{--            <p>Language</p>--}}
        {{--            <div class="dropdown">--}}
        {{--                <button class="btn btn-secondary dropdown-toggle" type="button" id="localizations" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
        {{--                    {{ LaravelLocalization::getCurrentLocaleNative() }}--}}
        {{--                </button>--}}
        {{--                <div class="dropdown-menu" aria-labelledby="localizations">--}}
        {{--                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
        {{--                        <a rel="alternate"--}}
        {{--                           class="@if(LaravelLocalization::getCurrentLocale() == $localeCode) active @endif"--}}
        {{--                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
        {{--                            {{ $properties['native'] }}--}}
        {{--                        </a>--}}
        {{--                    @endforeach--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </ul>--}}
    </nav>

    <div class="container-fluid pb-3">
        <div id="content" class="pt-0">
            <main role="main" class="">
                <div class="row bg-white border-bottom pt-3 pb-3 mb-3" style="min-height: 70px">
                    <nav class="navbar navbar-expand-md bg-white navbar-light d-md-none pe-0 py-0">
                        <button class="navbar-toggler" type="button" id="sidebarCollapse" data-target="#sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </nav>
                    <div class="col text-nowrap align-self-center my-1">
                        @yield('breadcrumbs')
                    </div>
                    <div id="toolbar" class="text-end pt-2 pt-md-0 col-12 col-md-auto">
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
