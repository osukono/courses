<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EZ1NJVN9LJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-EZ1NJVN9LJ');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="{{ $seo['keywords'] ?? ''}}">
    <meta name="description" content="{{ $seo['description'] ?? '' }}">
    <meta name="google-site-verification" content="jegwJ_cqrwtqJCQQ47IEzRrv2FBYi_TYXoVtpy1s96M"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $seo['title'] ?? config('app.name', 'Yummy Lingo') }}</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('favicon-16x16.png') }}">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}"></script>
</head>
<body class="d-flex flex-column h-100">
<header>
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container mt-2 mb-2" style="z-index: 100;">
            <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ URL::asset('images/brand_header.svg?v=2') }}" alt="Yummy Lingo">
            </a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto me-md-2 me-0">
{{--                    <a href="{{ route('teachers') }}" class="btn btn-lg btn-link">--}}
{{--                        {{ __('web.header.teachers') }}--}}
{{--                    </a>--}}
{{--                    @can(\App\Library\Permissions::view_admin_panel)--}}
                        <a class="btn btn-lg btn-link" href="{{ route('admin.dev.courses.index') }}">
                            {{ __('web.header.console') }}
                        </a>
{{--                    @endcan--}}
                    @auth()
                        <a class="btn btn-lg btn-link" href="#"
                           onclick="document.getElementById('logout').submit()">{{ __('web.header.logout') }}</a>
                        <form class="d-none" action="{{ route('logout') }}" method="post" id="logout">
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
            <a target="_blank" rel="noopener" class="btn btn-lg btn-outline-primary rounded-pill d-none d-md-block"
               href="{{ route('download') }}">{{ __('web.header.download') }}</a>
        </div>
    </nav>
</header>

<main id="app" role="main" class="flex-shrink-0">
    @yield('content')
</main>

<footer class="footer mt-auto py-3 small">
    <div class="container">
        <div class="row mt-4">
            <div class="col-12 text-center col-md-6 text-md-start">
                <div class="row">
                    <div class="col-12 col-lg-auto">
                        <div class="row mb-4">
                            <div class="col">
                                <img src="{{ URL::asset('images/brand_footer.svg?v=2') }}" alt="Yummy Lingo"
                                     width="169" height="25">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="text-center">
                                    <a href="{{ __('web.index.section.app.links.android') }}" target="_blank"
                                       rel="noopener">
                                        <img
                                            src="{{ URL::asset('images/' . __('web.index.section.app.badges.google_play.image')) }}"
                                            alt="{{ __('web.index.section.app.badges.google_play.alt') }}"
                                            width="148" height="44" class="mx-1 mb-2">
                                    </a>
                                    <a href="{{ __('web.index.section.app.links.ios') }}" target="_blank"
                                       rel="noopener">
                                        <img
                                            src="{{ URL::asset('images/' . __('web.index.section.app.badges.app_store.image')) }}"
                                            alt="{{ __('web.index.section.app.badges.app_store.alt') }}"
                                            width="131.630477" height="44" class="mx-1 mb-2">
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center pt-md-6 d-none d-lg-block">
                        <img class="shadow-sm" src="{{ URL::asset('images/download.svg?v=2') }}" width="100"
                             height="100"
                             alt="{{ __('web.footer.download') }}">
                    </div>
                </div>
            </div>
            <div class="col-12 text-center pt-5 col-md-3 text-md-start pt-md-0">
                <div class="row">
                    <div class="col">
                        <h6 class="text-white mb-3">{{ __('web.footer.contact_us') }}</h6>
                        <div>support@yummylingo.com</div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center pt-5 col-md-3 text-md-end pt-md-0">
                <div class="row">
                    <div class="col">
                        <h6 class="text-white mb-3">{{ __('web.footer.social.title') }}</h6>
                        <div>
                            <a target="_blank" rel="noopener" href="https://www.instagram.com/yummy_lingo/">
                                <img src="{{ URL::asset('images/instagram.svg') }}" data-bs-toggle="tooltip"
                                     title="{{ __('web.footer.social.instagram') }}" alt="Instagram"
                                     width="24" height="24"/>
                            </a>
                            <a class="ps-2" target="_blank" rel="noopener" href="https://t.me/yummy_lingo">
                                <img src="{{ URL::asset('images/telegram.svg') }}" data-bs-toggle="tooltip"
                                     title="{{ __('web.footer.social.telegram') }}" alt="Telegram"
                                     width="24" height="24"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 order-2 col-md-8 order-md-1">
                <div class="row">
                    <div class="col-12 text-center order-2 mt-3 col-md-auto text-md-start order-md-1 mt-md-0">
                        <span class="text-nowrap">
                            {{ __('web.footer.copyright', ['year' => now()->year]) }}
                        </span>
                    </div>
                    <div class="col-12 text-center order-1 mt-3 col-md text-md-start order-md-2 mt-md-0">
                        <a href="{{ route('privacy') }}"
                           class="font-weight-bold text-white text-nowrap">{{ __('web.footer.privacy') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center order-1 mt-3 col-md-4 text-md-end order-md-2 mt-md-0">
                <img class="me-2" src="{{ URL::asset('images/globe.svg') }}" alt="Languages" width="20" height="20">
                <span class="align-middle text-nowrap">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a rel="alternate"
                           class="@if(LaravelLocalization::getCurrentLocale() == $localeCode) text-white font-weight-bold @endif text-uppercase text-decoration-none"
                           style="color: #D9DFF6" hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $localeCode }}
                    </a>
                        @if (! $loop->last) / @endif
                    @endforeach
                </span>
            </div>
        </div>
    </div>
</footer>

@stack('scripts')

</body>
</html>
