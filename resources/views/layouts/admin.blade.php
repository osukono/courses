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
    <script src="{{ mix('js/admin_3x0xof.js') }}" defer></script>
    <script src="{{ mix('js/admin_vue_3x0xof.js') }}" defer></script>
</head>
<body>
<div id="app" class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar" {{--class="border-right border-light"--}}>
        <div class="sidebar-header text-center mt-2">
            <a href="{{ route('welcome') }}"><h3 class="brand">Yummy Lingo</h3></a>
            <a class="{{ active_menu($current, \App\Library\Sidebar::profile) }}" href="{{ route('admin.profile') }}">{{ Auth::getUser()->name }}</a>
        </div>

        <ul class="list-unstyled">
            <li>
                <a class="{{ active_menu($current, \App\Library\Sidebar::dashboard) }}"
                   href="{{ route('admin.dashboard') }}">
                    <i data-feather="activity"></i>
                    <div class="link">Dashboard</div>
                </a>
            </li>
            @can(\App\Library\Permissions::view_content)
                <li>
                    <a class="{{ active_menu($current, \App\Library\Sidebar::content) }}"
                       href="{{ route('admin.content.index') }}">
                        <i data-feather="book-open"></i>
                        <div class="link">Content</div>
                    </a>
                </li>
            @endcan
            @can(\App\Library\Permissions::view_courses)
                <li>
                    <a class="{{ active_menu($current, \App\Library\Sidebar::courses) }}"
                       href="{{ route('admin.courses.index') }}">
                        <i data-feather="book"></i>
                        <div class="link">Courses</div>
                    </a>
                </li>
            @endcan
        </ul>
        @role(\App\Library\Roles::admin)
        <ul class="list-unstyled">
            <li>
                <a class="{{ active_menu($current, \App\Library\Sidebar::languages) }}"
                   href="{{ route('admin.languages.index') }}">
                    <i data-feather="globe"></i>
                    <div class="link">Languages</div>
                </a>
            </li>
            <li>
                <a class="{{ active_menu($current, \App\Library\Sidebar::topics) }}"
                   href="{{ route('admin.topics.index') }}">
                    <i data-feather="message-square"></i>
                    <div class="link">Topics</div>
                </a>
            </li>
            <li>
                <a class="{{ active_menu($current, \App\Library\Sidebar::locales) }}"
                   href="{{ route('admin.app.locales.index') }}">
                    <i data-feather="list"></i>
                    <div class="link">Localizations</div>
                </a>
            </li>
        </ul>
        <ul class="list-unstyled">
            <li>
                <a class="{{ active_menu($current, \App\Library\Sidebar::users) }}"
                   href="{{ route('admin.users.index') }}">
                    <i data-feather="users"></i>
                    <div class="link">Users</div>
                </a>
            </li>
        </ul>
        @endrole

    </nav>
    <!-- Page Content -->
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
</body>
</html>
