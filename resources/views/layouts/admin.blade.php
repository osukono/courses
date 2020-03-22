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
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            @can(\App\Library\Permissions::view_content)
                <li>
                    <a href="{{ route('admin.content.index') }}">Content</a>
                </li>
            @endcan
            @can(\App\Library\Permissions::view_courses)
                <li>
                    <a href="{{ route('admin.courses.index') }}">Courses</a>
                </li>
            @endcan
        </ul>
        @role(\App\Library\Roles::admin)
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('admin.languages.index') }}">Languages</a>
            </li>
            <li>
                <a href="{{ route('admin.topics.index') }}">Topics</a>
            </li>
        </ul>
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('admin.users.index') }}">Users</a>
            </li>
        </ul>
        @endrole

    </nav>
    <!-- Page Content -->
    <div id="content" class="">
        <nav class="navbar navbar-expand-md navbar-light d-md-none">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" id="sidebarCollapse" data-target="#sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <main role="main" class="">
            <div class="row mb-3">
                <div class="col text-nowrap mb-1">
                    @yield('breadcrumbs')
                </div>
                <div class="col-auto">
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
