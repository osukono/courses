<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="{{ __('web.html.seo.keywords') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($htmlTitle) ? $htmlTitle : config('app.name', 'Yummy Lingo') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" async defer></script>
    <script src="{{ mix('js/vue.js') }}" async defer></script>
</head>
<body class="d-flex flex-column h-100">
<header>
    <nav class="navbar navbar-expand-md navbar-light bg-white">
        <div class="container mt-2">
            <a class="navbar-brand" href="{{ route('welcome') }}"><h3>{{ env('APP_NAME') }}</h3></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="{{ route('login') }}">{{ __('Log In') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-secondary"
                                   href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="{{ route('home') }}">{{ __('My Courses') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-secondary" href="#"
                               role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @can(\App\Library\Permissions::view_admin_panel)
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Administration</a>
                                @endcan
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>

<main role="main" class="pt-4 flex-shrink-0">
    <div id="app" class="container">
        @yield('content')
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <div class="row px-3">
            <div class="col-lg-auto text-lg-left text-center">
                <span
                    class="text-black-50">Copyright &copy; {{ now()->year }} Yummy Lingo. {{ __('All rights reserved.') }}</span>
            </div>
            <div class="col-lg mt-lg-0 text-lg-right mt-2 text-center">
                <div class="dropdown dropup d-inline">
                    <a href="#" class="dropdown-toggle text-secondary" id="language" data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">{{ LaravelLocalization::getCurrentLocaleNative() }}</a>
                    <div class="dropdown-menu" aria-labelledby="language">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('privacy') }}" class="ml-3 text-secondary">{{ __('Privacy Policy') }}</a>
{{--                <a href="{{ route('terms') }}" class="ml-3 text-secondary">{{ __('Terms of Service') }}</a>--}}
                {{--                <a href="#" id="complaint" onclick="$('#complaint').tooltip('show'); return false;" class="ml-3 text-secondary" title="{{ __("There isn't one you can complain to. Just practice.") }}">{{ __('Complain') }}</a>--}}
            </div>
        </div>
    </div>
</footer>

@stack('scripts')

</body>
</html>
