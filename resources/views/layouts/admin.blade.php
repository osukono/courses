<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
    <script src="{{ mix('js/admin.js') }}"></script>
    <script src="{{ mix('js/vue.js') }}" async defer></script>
</head>
<body>
<div id="app" class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar" {{--class="border-right border-light"--}}>
        <div class="sidebar-header text-center mt-2">
            <a href="{{ route('welcome') }}"><h3 class="brand">{{ env('APP_NAME') }}</h3></a>
        </div>

        <ul class="list-unstyled">
            <li>
                <a class="{{ (isset($current) && $current == \App\Library\Sidebar::dashboard? 'active' : '') }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            @can(\App\Library\Permissions::view_content)
                <li>
                    <a class="{{ (isset($current) && $current == \App\Library\Sidebar::content ? 'active' : '') }}" href="{{ route('admin.content.index') }}">Content</a>
                </li>
            @endcan
            @can(\App\Library\Permissions::view_courses)
                <li>
                    <a class="{{ (isset($current) && $current == \App\Library\Sidebar::courses ? 'active' : '') }}" href="{{ route('admin.courses.index') }}">Courses</a>
                </li>
            @endcan
        </ul>
        @role(\App\Library\Roles::admin)
        <ul class="list-unstyled">
            <li>
                <a class="{{ (isset($current) && $current == \App\Library\Sidebar::languages ? 'active' : '') }}" href="{{ route('admin.languages.index') }}">Languages</a>
            </li>
            <li>
                <a class="{{ (isset($current) && $current == \App\Library\Sidebar::topics ? 'active' : '') }}" href="{{ route('admin.topics.index') }}">Topics</a>
            </li>
        </ul>
        <ul class="list-unstyled">
            <li>
                <a class="{{ (isset($current) && $current == \App\Library\Sidebar::users ? 'active' : '') }}" href="{{ route('admin.users.index') }}">Users</a>
            </li>
        </ul>
        @endrole

    </nav>
    <!-- Page Content -->
    <div class="container-fluid pb-3">
    <div id="content" class="pt-0">
        <nav class="navbar navbar-expand-md bg-white navbar-light d-md-none">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" id="sidebarCollapse" data-target="#sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <main role="main" class="">
            <div class="row bg-white border-bottom pt-3 pb-3 mb-3" style="min-height: 70px">
                <div class="col text-nowrap align-self-center">
                    @yield('breadcrumbs')
                </div>
                <div class="col-auto align-self-center">
                    @yield('toolbar')
                </div>
            </div>
            @stack('progress')
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

<script>
    $(document).ready(function () {
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle^=confirmation]',
            singleton: true,
            popout: true,
            btnOkClass: 'btn btn-info btn-sm',
            btnCancelLabel: '{{ __('admin.form.cancel') }}',
            btnCancelClass: 'btn btn-outline-info btn-sm',
            onConfirm: function () {
                let form = $(this)[0].getAttribute('data-form');
                document.getElementById(form).submit();
            }
        });

        // $('.toast').toast({
        //     autohide: false
        // });
        // $('.toast').toast('show');
    });
</script>

</body>
</html>
